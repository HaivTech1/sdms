<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $properties = Property::all();

        $properties->each(function ($property) use ($users) {
            Booking::factory()
                ->count(3)
                ->state(new Sequence(
                    fn () => [
                        'author_id'         => $users->random()->id,
                        'property_uuid'    => $property->id(),
                        'paymentStatus'    => 1,
                        'total'    => $property->price()
                    ],
                ))
                ->create();
        });
    }
}