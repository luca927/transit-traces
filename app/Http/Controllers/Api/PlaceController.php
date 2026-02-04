<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getPlaces(Request $request)
    {
        $places = Place::all();
        return response()->json($places);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $place = new Place();
    $place->name = $request->name;
    $place->lat = $request->lat; // Prende 'lat' dal JS e lo salva come 'latitude'
    $place->lng = $request->lng;
    $place->description = $request->description;
    $place->video_url = $request->video_url;
    $place->type = $request->type ?? 'spot'; // Default a 'spot' se non specificato
    $place->save();

    return response()->json(['place' => $place]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
