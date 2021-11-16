<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
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
            Event::create([
                'event_name' => $faker->numerify('Churchill ###'),
                'poster_url' => $faker->imageUrl(),
                'max_attendees' => $faker->numberBetween($min = 100, $max = 30),
                'regular_price' => $faker->numberBetween($min = 700, $max = 1000),
                'vip_price' => $faker->numberBetween($min = 1000, $max = 3000),
                'venue_name' => $faker->streetName(),
                'event_date' => $faker->date($format = 'Y-m-d', $max = 'now')
            ]);
        }
    }
}
