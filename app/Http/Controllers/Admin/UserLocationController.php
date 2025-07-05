<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CurrentLocation;
use Illuminate\Http\JsonResponse;

class UserLocationController extends Controller
{
    /**
     * Display map view with all user locations.
     */
    public function index()
    {
        // Fetch all current locations with user info
        // Assumes each user has only one location (latest entry)
        $locations = CurrentLocation::with('user')->get();

        return view('admin.current-locations.map', compact('locations'));
    }

    public function ajax(): \Illuminate\Http\JsonResponse
    {
        $locations = \App\Models\CurrentLocation::with('user')->get();

        return response()->json($locations->map(function ($loc) {
            return [
                'latitude' => $loc->latitude,
                'longitude' => $loc->longitude,
                'updated_at_formatted' => $loc->updated_at->format('d-m-Y h:i A'),
                'user' => [
                    'name' => $loc->user->name ?? null,
                    'email' => $loc->user->email ?? null,
                ],
            ];
        }));
    }
}
