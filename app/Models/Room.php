<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

    protected $casts = [
    'user_id' => 'integer',
];

     protected $table = 'rooms';
    
    protected $fillable = [
        'id',
        'hotel_id',
        'room_number',
        'name',
        
        'slug',
        'description',
        'max_guests',
        'size',
        'amenities ',
        'quantity',
        'is_available',
    ];
    /**
     * Get bookings for the room.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
