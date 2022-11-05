<?php

namespace App;

use App\Configuration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timesheet extends Model
{
    use SoftDeletes;

    public $table = 'timesheets';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'date',
        'start_time',
        'end_time',
        'hours',
        'notes',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function timekeeping()
    {
        return $this->hasOne(Timekeeping::class);
    }

    public static function getTimesheetToCheckOut($user_id)
    {
        return self::isNotCheckOut($user_id);
    }

    public static function isNotCheckOut($user_id)
    {
        $isNotCheckOut = false;

        $timesheet = Timesheet::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->firstWhere('hours', '00:00:00');

        if ($timesheet) {

            $start = Carbon::parse($timesheet->start_time);

            $limit_hours = (int)Configuration::get('limit_hours');

            $isNotCheckOut = Carbon::now()->lte($start->endOfDay()->addHours($limit_hours));
        }

        return ($timesheet && $isNotCheckOut) ? $timesheet : null;
    }
}
