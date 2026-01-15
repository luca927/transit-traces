<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Place;

Route::middleware('web')->group(function () {
    Route::get('/places', function () {
        return response()->json(Place::all());
    });
});