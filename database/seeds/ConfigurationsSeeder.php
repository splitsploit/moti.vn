<?php

use App\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configurations = [
            [
                'id'          => 1,
                'key'         => 'start_booking',
                'default'     => 'Friday, 6',
                'value'       => 'Friday, 7',
                'description' => 'Weekday and start hour for booking.'
            ],
            [
                'id'          => 2,
                'key'         => 'end_booking',
                'default'     => 'Sunday, 23',
                'value'       => null,
                'description' => 'Weekday and end hour for booking.'
            ],
            [
                'id'          => 3,
                'key'         => 'available_booking_time',
                'default'     => '5',
                'value'       => '4',
                'description' => 'Maximum number available for booking.'
            ],
            [
                'id'          => 4,
                'key'         => 'limit_hours',
                'default'     => '0',
                'value'       => '1',
                'description' => 'Limit hours for check-out.'
            ]
        ];

        Configuration::insert($configurations);
    }
}
