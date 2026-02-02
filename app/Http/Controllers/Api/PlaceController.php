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
        return Place::all();
        return response()->json(['places' => $places], 201);
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
