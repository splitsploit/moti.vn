<?php

namespace App;

use Gate;
use stdClass;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTime extends Model
{
    use SoftDeletes;

    public $table = 'booking_time';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'hours',
        'd_hours',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Check permission user
     */
    public function permission($permission)
    {
        return Gate::allows('booking_time_access') || (Gate::allows($permission) && auth()->user()->id == $this->user_id);
    }

    /**
     * Check expiration time
     */
    public function expiration()
    {
        if (Gate::allows('booking_time_access')) {

            return true;
        }

        $startTime = Carbon::parse($this->start_time);

        $endTime = Carbon::parse($this->end_time);

        return self::isTimeValid($startTime, $endTime);
    }

    public function toEvent()
    {
        $event = new stdClass;

        $event->id = $this->id;

        $event->resourceId = $this->user_id;

        $event->title = $this->user->name;

        $event->start = $this->start_time;

        $event->end = $this->end_time;

        $event->color = $this->user->roles->first() ? $this->user->roles->first()->color : '#FFFFFF';

        $event->editable = $this->permission('booking_time_edit');

        $event->borderColor = $event->editable ? '#000000' : $event->color;

        $event->url = Gate::any(['booking_time_access', 'booking_time_show']) ? route('admin.bookingTime.show', $event->id) : '';

        return $event;
    }

    /**
     * Booking time starts at 07:00:00 Friday and ends at 23:00:00 Sunday.
     */
    public static function isOpenBookingTime()
    {
        if (Gate::allows('booking_time_access')) {

            return true;
        }

        $startConfig = explode(',', Configuration::get('start_booking'));
       
        $endConfig = explode(',', Configuration::get('end_booking'));

        if (count($startConfig) != 2 || count($endConfig) != 2) {

            return false;
        }

        $now = Carbon::now();

        $startBooking = Carbon::parse('this ' . trim($startConfig[0]))->addHours((int)trim($startConfig[1]));

        $endBooking = Carbon::parse('this ' . trim($endConfig[0]))->addHours((int)trim($endConfig[1]));

        if ($startBooking->gt($endBooking)) {
            $startBooking = $now;
        }

        if ($endBooking->gt((clone $now)->endOfWeek())) {
            $endBooking = (clone $now)->endOfWeek();
        }

        return $now->gte($startBooking) && $now->lte($endBooking);
    }

    /**
     * Check time booking is valid.
     */
    public static function isTimeValid($startTime, $endTime)
    {
        $dateFrom = Carbon::parse('next Monday');

        $dateTo = Carbon::parse('next Monday')->addDays(7);

        $validWeek = $dateFrom->lte($startTime) && $dateTo->gte($endTime);

        return $validWeek;
    }

    /**
     * Check time booking is available.
     */
    public static function isTimeAvailable($userId, $startTime, $endTime, $bookingTime)
    {
        // Query current user
        $hasBooked = BookingTime::query()
            ->when($userId == auth()->user()->id, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->when($bookingTime, function ($query) use ($bookingTime) {
                $query->where('id', '<>', $bookingTime->id);
            })->where([
                ['start_time', '<', $endTime->toDateTimeString()],
                ['end_time', '>', $startTime->toDateTimeString()]
            ])->count();

        if (!!$hasBooked) {

            return false;
        }

        $maximum = 0;

        $roleId = User::whereId($userId)->first()->roles->modelKeys();

        // Query available booking time
        $queryAvailable = AvailableBookingTime::where('week_days', 'like', '%' . $startTime->dayOfWeekIso . '%')
            ->when($endTime->toTimeString() != "00:00:00", function ($query) use ($endTime) {
                $query->where('start', '<', $endTime->toTimeString());
            })
            ->whereRaw('( end > ? OR end = "00:00:00" )', $startTime->toTimeString());

        $queryByRole = clone $queryAvailable;

        $queryByRole->where('role_id', $roleId);

        if ($queryByRole->exists()) {

            $maximum = $queryByRole->min('maximum');
        } else {

            $available_booking_time = (int)Configuration::get('available_booking_time');

            $maximum = $queryAvailable->whereNull('role_id')->min('maximum') ?? $available_booking_time;
        }

        // Query all user booked
        $booked = BookingTime::query()
            ->join('role_user', function ($join) {
                $join->on('booking_time.user_id', '=', 'role_user.user_id');
            })->where([
                ['booking_time.start_time', '<', $endTime->toDateTimeString()],
                ['booking_time.end_time', '>', $startTime->toDateTimeString()]
            ])->when($bookingTime, function ($query) use ($bookingTime) {
                $query->where('booking_time.id', '<>', $bookingTime->id);
            })->when($queryByRole->exists(), function ($query) use ($roleId) {
                $query->where('role_user.role_id', $roleId);
            })->distinct('booking_time.user_id')
            ->count('booking_time.user_id');

        return $booked < $maximum;
    }

    /**
     * Check user can booking time.
     */
    public static function checkCanBookingTime($user_id, $start_time, $end_time, $bookingTime)
    {
        if (Gate::allows('booking_time_access')) {

            return true;
        }

        $startTime = Carbon::parse($start_time);

        $endTime = Carbon::parse($end_time);

        return self::isTimeValid($startTime, $endTime) && self::isTimeAvailable($user_id, $startTime, $endTime, $bookingTime);
    }

    /**
     * Check booked time return result:
     * 1: The time is available, can create, edit, delete.
     * 0: The time is unavailable, can not create booking time.
     * -1: The time is expired, can not edit, delete.
     */
    // public static function checkResultBookedTime($user_id, $bookedTime)
    // {
    //     if (Gate::allows('booking_time_access')) {

    //         return 1;
    //     }

    //     $startTime = Carbon::parse($bookedTime->start_time);

    //     $endTime = Carbon::parse($bookedTime->end_time);

    //     if (!self::isTimeValid($startTime, $endTime)) {

    //         return -1;
    //     }

    //     $isTimeAvailable = self::isTimeAvailable($startTime, $endTime, $bookedTime);

    //     return $isTimeAvailable ? 1 : 0;
    // }
}
