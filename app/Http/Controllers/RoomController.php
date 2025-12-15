<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        return view('welcome1', compact('rooms')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Hotel $hotel)
    {
        return view('rooms.create', compact('hotel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'room_number' => 'nullable|string|max:50',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'city' => 'nullable|string',
            'max_guests' => 'nullable|integer',
            'size' => 'nullable|integer',
            'quantity' => 'nullable|integer',
        ]);

        $room = Room::create(array_merge($validated, [
            'hotel_id' => $hotel->id,
            'slug' => $validated['slug'] ?? 
                \Illuminate\Support\Str::slug($validated['name'] . '-' . uniqid()),
        ]));

        return redirect()->route('hotels.show', $hotel)->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
       $hotel->load('rooms'); 
         return view('hotels.show', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
       return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
       // Authorization: only owner can update
       

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'room_number' => 'nullable|string|max:50',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'city' => 'nullable|string',
            'max_guests' => 'nullable|integer',
            'size' => 'nullable|integer',
            'quantity' => 'nullable|integer',
        ]);

        

        $room->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
