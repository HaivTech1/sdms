<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class BookingSeeder extends Seeder
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