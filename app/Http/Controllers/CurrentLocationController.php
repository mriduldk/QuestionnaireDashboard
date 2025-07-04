<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurrentLocation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CurrentLocationController extends Controller
{
    public function upsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_location_id' => 'required|uuid',
            'user_id' => 'nullable|uuid',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'updated_at' => 'nullable|string',
            'updated' => 'boolean'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422);
        }

        $data = $validator->validated();

        $location = CurrentLocation::find($data['current_location_id']);

        if ($location) {
            $location->update($data);
            $message = 'Current location updated';
        } else {
            $location = CurrentLocation::create($data);
            $message = 'Current location created';
        }

        return ApiResponse::success($location, $message);

    }
}
