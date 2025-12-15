<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $city = $request->query('city');

        $hotels = Hotel::when($city, function ($query, $city) {
            $query->where('city', 'like', "%{$city}%");
        })->paginate(5);

        return view('welcome1', compact('hotels', 'city'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hotels.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'star_rating' => 'nullable|integer|min:0|max:5',
            'slug' => 'required|string|max:255|unique:hotels,slug',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|string',
        ]);

        $hotels = Hotel::create(array_merge($validated, [
            'user_id' => Auth::id(),
        ]));

        return redirect()->back()->with('success', 'Hotel created successfully.');
    }

    /**
     * Display the specified resource.
     */
     public function show(Hotel $hotel)
     {
         $hotel->load('rooms'); 
         return view('hotels.show', compact('hotel'));
     }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        return view('hotels.edit', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {
        // Authorization: only owner can update
        if (Auth::id() !== $hotel->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'star_rating' => 'nullable|integer|min:0|max:5',
            'slug' => 'required|string|max:255|unique:hotels,slug,' . $hotel->id,
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $hotel->update($validated);

        return redirect()->route('hotels.show', $hotel)->with('success', 'Hotel updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
$hotel->delete();

                return redirect()->route('hotels')->with('success', 'Hotel Deleted successfully.');

    }
}
