<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    // تحديد الجدول المرتبط بالنموذج
    protected $table = 'hotels';
    
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'city',
        'star_rating',
        'slug',
        'description',
        'address',
        'phone',
        'email',
        'country',
    ];


    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    public function availableRooms($checkIn, $checkOut)
    {
        return $this->rooms()->whereDoesntHave('bookings', function($query) use ($checkIn, $checkOut) {
            $query->where(function($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in', [$checkIn, $checkOut])
                  ->orWhereBetween('check_out', [$checkIn, $checkOut]);
            })->whereNotIn('status', ['cancelled']);
        });
    }

    /**
     * Use the slug column for route model binding instead of the id.
     */
    

} 
