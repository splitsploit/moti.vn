<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvailableBookingTime extends Model
{
    use SoftDeletes;

    public $table = 'available_booking_time';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'week_days',
        'start',
        'end',
        'maximum',
        'role_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const WEEK_DAYS = [
        '1' => 'Monday',
        '2' => 'Tuesday',
        '3' => 'Wednesday',
        '4' => 'Thursday',
        '5' => 'Friday',
        '6' => 'Saturday',
        '7' => 'Sunday',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function weekDays()
    {
        return collect(explode(',', $this->week_days));
    }

    public static function getAvailableBooking($weekDays, $start, $end, $roles)
    {
        $maximum = 0;

        $query = self::where('week_days', 'like', '%' . $weekDays . '%')
            ->where('start', '<', $end)
            ->whereRaw('( end > ? OR end = "00:00:00" )', $start);

        $queryByRole = clone $query;

        $queryByRole->where('role_id', $roles->modelKeys());

        if ($queryByRole->exists()) {

            $maximum = $queryByRole->min('maximum');
        } else {
            
            $available_booking_time = (int)Configuration::get('available_booking_time');

            $maximum = $query->whereNull('role_id')->min('maximum') ?? $available_booking_time;
        }

        return $maximum;
    }
}
