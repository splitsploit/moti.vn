<?php

namespace App;

use stdClass;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timekeeping extends Model
{
    use SoftDeletes;

    public $table = 'timekeepings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user',
        'email',
        'role',
        'user_id',
        'timesheet_id',
        'start_time',
        'end_time',
        'normal_time',
        'special_time',
        'total_time',
        'basic_salary',
        'reward_salary',
        'reward_percent',
        'salary',
        'reward',
        'total',
        'notes',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function timesheet()
    {
        return $this->belongsTo(Timesheet::class, 'timesheet_id');
    }

    public static function calculate($timesheet)
    {
        $timekeeping = new stdClass;

        $user = $timesheet->user;

        $role = $user->roles->first();

        $timekeeping->user = $user->name;

        $timekeeping->email = $user->email;

        $timekeeping->role = $role->title;

        $timekeeping->basic_salary = $role->level * $user->rate * 10000;

        $timekeeping->start_time = $timesheet->start_time;

        $timekeeping->end_time = $timesheet->end_time;

        $timekeeping->notes = $timesheet->notes;

        $start = Carbon::parse($timesheet->start_time);

        $end = Carbon::parse($timesheet->end_time);

        //Check if diff In a day
        if ((clone $start)->startOfDay()->diffInDays((clone $end)->startOfDay())) {

            $timekeeping->total_time = $end->diffInMinutes($start);

            $end = (clone $start)->endOfDay();
        } else {

            $timekeeping->total_time = $end->diffInMinutes($start);
        }

        $specialTime = SpecialTime::getSpecialTime($start, $end, $role->id);

        $timekeeping->normal_time = $timekeeping->total_time;

        $timekeeping->special_time = 0;

        $timekeeping->reward_salary = 0;

        $timekeeping->reward_percent = 0;

        if ($specialTime) {

            $spec_start = (clone $start)->setTimeFromTimeString($specialTime['start']);

            $spec_end = (clone $end)->setTimeFromTimeString($specialTime['end']);

            if ($start->lt($spec_start) && $end->lt($spec_end)) {

                $timekeeping->special_time = $end->diffInMinutes($spec_start);

                $timekeeping->normal_time = $timekeeping->total_time - $timekeeping->special_time;
            } else if ($start->gte($spec_start) && $end->lte($spec_end)) {

                $timekeeping->special_time = $timekeeping->total_time;

                $timekeeping->normal_time = 0;
            } else if ($start->gt($spec_start) && $end->gt($spec_end)) {

                $timekeeping->special_time = $spec_end->diffInMinutes($start);

                $timekeeping->normal_time = $timekeeping->total_time - $timekeeping->special_time;
            } else {

                $timekeeping->special_time = $spec_end->diffInMinutes($spec_start);

                $timekeeping->normal_time = $timekeeping->total_time - $timekeeping->special_time;
            }

            $timekeeping->reward_salary = $specialTime['reward_percent'] / 100 * $timekeeping->basic_salary;

            $timekeeping->reward_percent = $specialTime['reward_percent'];
        }

        $timekeeping->salary = $timekeeping->normal_time / 60 * $timekeeping->basic_salary;

        $timekeeping->reward = $timekeeping->special_time / 60  * $timekeeping->reward_salary;

        $timekeeping->total = $timekeeping->salary + $timekeeping->reward;

        $timekeeping->user_id = $user->id;

        return $timesheet->timekeeping()->updateOrCreate(
            [
                'user_id'      => $timesheet->user_id,
                'timesheet_id' => $timesheet->id
            ],
            (array)$timekeeping
        );
    }
}
