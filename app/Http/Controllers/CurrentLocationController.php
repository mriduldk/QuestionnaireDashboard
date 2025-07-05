<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurrentLocation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\LocationHistory;
use App\Helpers\ApiResponse;

class CurrentLocationController extends Controller
{
    public function upsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|uuid',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'updated_at' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422);
        }

        $data = $validator->validated();

        $location = CurrentLocation::where('user_id', $data['user_id'])->first();

        if ($location) {
            $location->update($data);
            $location->updated_at = now();
            $message = 'Current location updated';
        } else {
            $data['current_location_id'] = Str::uuid();
            $data['updated_at'] = now();

            $location = CurrentLocation::create($data);
            $message = 'Current location created';
        }


        // 2️⃣ Always insert into LocationHistory
        $historyData = array_merge($data, [
            'location_history_id' => Str::uuid(),
            'created_at' => now(),
        ]);

        $history = LocationHistory::create($historyData);

        return ApiResponse::success(200, $message, "currentLocation", $location);
    }


}
