<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(room $rooms)
    {
        // عرض نموذج الحجز
        $rooms = Room::all();
        return view('booking.create', compact('rooms'));
    }
    public function checkAvailability(Request $request)
    {
        // تأكد من صحة البيانات
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $roomId = $request->room_id;
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

        // 1. تحقق إذا الغرفة متاحة أساساً
        $room = Room::find($roomId);
        if ($room->status != 'available') {
            return response()->json([
                'available' => false,
                'message' => 'الغرفة غير متاحة حالياً'
            ]);
        }

        // 2. تحقق من التعارض في التواريخ
        $hasConflict = Booking::where('room_id', $roomId)
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->exists();

        if ($hasConflict) {
            return response()->json([
                'available' => false,
                'message' => 'الغرفة مشغولة في التواريخ المطلوبة'
            ]);
        }

        // 3. كل شيء جيد
        return response()->json([
            'available' => true,
            'message' => 'الغرفة متاحة للحجز'
        ]);
    }

    public function simpleCheckAvailability($roomId, $checkIn, $checkOut)
    {
        // أبسط صيغة ممكنة
        $available = !Booking::where('room_id', $roomId)
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->exists();
            
        return $available;
    }
}