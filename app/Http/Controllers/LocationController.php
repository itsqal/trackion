<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function reverseGeocode(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'truck_id' => 'required'
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;


        $googleApiKey = config('services.google_maps.key');
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => "$lat,$lng",
            'key' => $googleApiKey
        ]);

        $address = $response['results'][0]['formatted_address'] ?? 'Unknown location';

        $truck = Truck::findOrFail($request->truck_id);

        $truck->update([
            'current_status' => 'dalam pengiriman'
        ]);

        Shipment::create([
            'truck_id' => $truck->id,
            'departure_latitude' => $lat,
            'departure_longitude' => $lng,
            'departure_location' => $address,
            'status' => 'perjalanan'
        ]);

        return response([
            'Message' => 'Success'
        ], 200)
        ->header('Content-Type', 'application/json');
    }
}
