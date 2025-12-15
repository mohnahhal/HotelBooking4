<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table= 'bookings';

    protected  $fillable = [
        'id',
        'booking_number',
        'room_number',
        'user_id',
        'room_id',
        'check_in',
        'check_out',
    ];

     public function room()
    {
        return $this->BelongsTo(Room::class);
    }
}
