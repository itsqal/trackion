<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Truck;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function startTracking(Request $request)
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

        $address = $response['results'][0]['formatted_address'] ?? 'Lokasi tidak diketahui';

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

    public function finishTracking(Request $request) 
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'truck_id' => 'required'
        ]);

        $truck = Truck::findOrFail($request->truck_id);
        $shipment = Shipment::where('truck_id', $truck->id)
                    ->latest()
                    ->first();

        $latOrigin = $shipment->departure_latitude;
        $lngOrigin = $shipment->departure_longitude; 
        $lat = $request->latitude;
        $lng = $request->longitude;

        $googleApiKey = config('services.google_maps.key');

        $reverseGeocodeResponse = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => "$lat,$lng",
            'key' => $googleApiKey
        ]);

        $address = $reverseGeocodeResponse['results'][0]['formatted_address'] ?? 'Lokasi tidak diketahui';

        $distanceMatrixReponse = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
            'origins' => "$latOrigin,$lngOrigin",
            'destinations' => "$lat,$lng",
            'key' => $googleApiKey
        ]);

        $distanceValue = $distanceMatrixReponse['rows'][0]['elements'][0]['distance']['value'] ?? 0;
        $distance = round($distanceValue / 1000, 2);

        $truck->update([
            'current_status' => 'tidak dalam pengiriman',
            'total_distance' => $truck->total_distance + $distance
        ]);

        $shipment->update([
            'final_location' => $address,
            'distance_traveled' => $distance,
            'completed_at' => now(),
            'status' => 'selesai'
        ]);

        return response([
            'Message' => 'Success',
        ], 200)
        ->header('Content-Type', 'application/json');
    }
}
