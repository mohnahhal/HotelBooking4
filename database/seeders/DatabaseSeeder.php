<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        
        $user = User::where('email', 'test@example.com')->first();

        $cities = [
            'Riyadh','Jeddah','Dammam','Mecca','Medina','Taif','Al-Khobar','Abha','Jizan','Al Hofuf',
            'Buraidah','Hail','Tabuk','Najran','Al-Ula','Khamis Mushait','Yanbu','Al-Madinah','Arar','Al-Qassim'
        ];

        foreach ($cities as $i => $city) {
            $name = "$city Hotel";
            Hotel::create([
                'user_id' => $user->id,
                'name' => $name,
                'slug' => Str::slug($name) . '-' . ($i+1),
                'description' => "A comfortable stay in $city.",
                'address' => "123 Main St, $city",
                'city' => $city,
                'country' => 'Saudi Arabia',
                'latitude' => null,
                'longitude' => null,
                'phone' => '0000000000',
                'email' => "info{$i}@example.com",
                'star_rating' => rand(3,5),
                'amenities' => json_encode(['wifi','parking','pool']),
                'images' => json_encode([]),
                'is_active' => true,
                'is_featured' => false,
                // set check-in/out to future dates spaced by index
                'check_in_date' => now()->addDays(7 + $i)->toDateString(),
                'check_out_date' => now()->addDays(8 + $i)->toDateString(),
                'policies' => 'Standard policies apply.'
            ]);
        }

        // Create rooms and some bookings for each hotel
        $hotels = Hotel::all();
        foreach ($hotels as $hotel) {
            for ($r = 1; $r <= 3; $r++) {
                $room = Room::create([
                    'hotel_id' => $hotel->id,
                    'room_number' => (string) $r,
                    'name' => "{$hotel->name} Room $r",
                    'slug' => Str::slug($hotel->name . ' room ' . $r) . "-{$r}",
                    'description' => 'Comfortable room',
                    'room_type_id' => 1,
                    'max_guests' => 2,
                    'size' => 25,
                    'amenities' => json_encode(['wifi', 'tv']),
                    'images' => json_encode([]),
                    'quantity' => 1,
                    'is_available' => true,
                ]);

                // Randomly create a booking for some rooms to test availability logic
                if (rand(0, 1) === 1) {
                    $ci = Carbon::now()->addDays(rand(2, 20));
                    $co = (clone $ci)->addDays(rand(1, 5));
                    Booking::create([
                        'booking_number' => Str::upper(Str::random(8)),
                        'user_id' => $user->id,
                        'room_id' => $room->id,
                        'check_in' => $ci->toDateString(),
                        'check_out' => $co->toDateString(),
                        'total_nights' => $ci->diffInDays($co),
                        'total_guests' => 1,
                        'guest_info' => json_encode(['name' => $user->name]),
                        'room_price' => rand(50, 300),
                        'tax' => 0,
                        'total_amount' => rand(50, 300),
                        'status' => 'confirmed',
                    ]);
                }
            }
        }
    }
}
