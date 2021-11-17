<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            Reservation::create([
                'user_id' => $faker->numberBetween($min = 1, $max = 30),
                'event_id' => $faker->numberBetween($min = 1, $max = 30),
                'event_name' => $faker->numerify('Churchill ###'),
                'venue_name' => $faker->streetName(),
                'regular_seats' => $faker->numberBetween($min = 1, $max = 3),
                'vip_seats' => $faker->numberBetween($min = 1, $max = 2),
                'event_date' => $faker->date($format = 'Y-m-d', $min = 'now')
            ]);
        }
    }
}
