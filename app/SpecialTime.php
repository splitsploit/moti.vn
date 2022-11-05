<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecialTime extends Model
{
    use SoftDeletes;

    public $table = 'specical_time';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'date',
        'start',
        'end',
        'reward_percent',
        'role_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public static function getSpecialTime($start, $end, $roleId)
    {
        //Query special time
        $query = SpecialTime::where([
            ['start', '<', $end->toTimeString()],
            ['end', '>', $start->toTimeString()]
        ])->orderByDesc('reward_percent');

        $queryRoleDay = clone $query;

        //Specific role and date
        $queryRoleDay
            ->where('role_id', $roleId)
            ->where('date', $start->toDateString());

        if ($queryRoleDay->exists()) {

            return $queryRoleDay->first();
        }

        //Specific date
        $queryDay = clone $query;

        $queryDay
            ->whereNull('role_id')
            ->where('date', $start->toDateString());

        if ($queryDay->exists()) {

            return $queryDay->first();
        }

        //Specific role
        $queryRole = clone $query;

        $queryRole
            ->where('role_id', $roleId)
            ->whereNull('date');

        if ($queryRole->exists()) {

            return $queryRole->first();
        }

        //Any role and date
        return $query
            ->whereNull('role_id')
            ->whereNull('date')
            ->first();
    }
}
