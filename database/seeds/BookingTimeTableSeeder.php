<?php

use App\BookingTime;
use Illuminate\Database\Seeder;

class BookingTimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start_time = now()->addHours(rand(1, 100));
        $booking_time = [
            [
                'id'         => 1,
                'user_id'    => 5,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 2,
                'user_id'    => 6,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 3,
                'user_id'    => 4,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 4,
                'user_id'    => 3,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 5,
                'user_id'    => 3,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 6,
                'user_id'    => 5,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 7,
                'user_id'    => 4,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 8,
                'user_id'    => 6,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 9,
                'user_id'    => 2,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 10,
                'user_id'    => 3,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 11,
                'user_id'    => 2,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 12,
                'user_id'    => 3,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 13,
                'user_id'    => 4,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 14,
                'user_id'    => 3,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 15,
                'user_id'    => 2,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
            [
                'id'         => 16,
                'user_id'    => 6,
                'start_time' => $start_time->format('Y-m-d H') . ':00',
                'end_time'   => $start_time->addHours(rand(1, 2))->format('Y-m-d H') . ':00',
                'hours'      => '00:00:00',
                'd_hours'    => 0
            ],
        ];

        BookingTime::insert($booking_time);
    }
}
