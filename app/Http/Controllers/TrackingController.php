<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function show (Truck $truck)
    {
        return view('tracking.show', compact('truck'));
    }
}
