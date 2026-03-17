<?php

namespace App\Http\Controllers;


use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller

{
 

public function index(Request $request)
{
    $query = Room::with(['place', 'images'])
        ->where(function ($q) {
            $q->where('status', 'Available'); // For private/shared rooms
             
        });

    // Filters
    if ($request->filled('location')) {
        $query->whereHas('place', function ($q) use ($request) {
            $q->where('location', 'like', '%' . $request->location . '%');
        });
    }

    if ($request->filled('room_type')) {
        $query->where('type', $request->room_type);
    }

    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    if ($request->filled('capacity')) {
        $query->where('capacity', '>=', $request->capacity);
    }

  
if ($request->boolean('cctv')) { // ✅ MATCHED name
    $query->where('cctv', true);
}
if ($request->boolean('laundry_area')) { // ✅ MATCHED name
    $query->where('laundry_area', true);
}
if ($request->boolean('allowed_pets')) { // ✅ MATCHED name
    $query->where('allowed_pets', true);
}
if ($request->boolean('has_wifi')) {
    $query->where('has_wifi', true);
}



    $rooms = $query->latest()->get();

    return view('home', compact('rooms'));
}



public function show($id)
{   
    // $room = Room::with('place', 'images')->findOrFail($id);
    // return view('homepage.show', compact('room'));

     $room = Room::with('images', 'place')->find($id);

    if (!$room) {
        return response()->json(['error' => 'Room not found'], 404);
    }

    return response()->json($room);
}

}