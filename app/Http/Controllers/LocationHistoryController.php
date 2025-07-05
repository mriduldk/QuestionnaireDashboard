<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\LocationHistory;

class LocationHistoryController extends Controller
{
    public function upsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location_history_id' => 'required|uuid',
            'user_id' => 'nullable|uuid',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'created_at' => 'nullable|string',
            'updated_at' => 'nullable|string',
            'updated' => 'boolean',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422);
        }

        $data = $validator->validated();

        $location = LocationHistory::find($data['location_history_id']);

        if ($location) {
            $location->update($data);
            $message = 'Location history updated';
        } else {
            $location = LocationHistory::create($data);
            $message = 'Location history created';
        }

        return ApiResponse::success(200, $message, "location", $location);

    }
}
