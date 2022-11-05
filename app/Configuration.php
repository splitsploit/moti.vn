<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    public $table = 'configurations';

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'key',
        'default',
        'value',
        'description',
        'created_at',
        'updated_at'
    ];

    public static function get($key)
    {
        $configure = Configuration::firstWhere('key', $key);

        if ($configure) {

            return $configure->value ?? $configure->default;
        }

        return null;
    }
}
