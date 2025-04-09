<?php

use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/location/reverse-geocode', [LocationController::class, 'reverseGeocode']);
