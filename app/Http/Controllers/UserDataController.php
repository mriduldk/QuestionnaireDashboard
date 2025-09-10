<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use App\Models\UserMessage;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    // Store IP Address
    public function store(Request $request)
    {
        $ip = $request->ip(); // Get client IP

        // Check if IP already exists
        $exists = UserData::where('ipaddress', $ip)->exists();

        if (!$exists) {
            UserData::create(['ipaddress' => $ip]);
            return response()->json(['message' => 'IP stored successfully']);
        }

        return response()->json(['message' => 'IP already exists']);
    }

    // Get count of stored IPs
    public function count()
    {
        $count = UserData::count();
        return response()->json(['count' => $count]);
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $ip = $request->ip();

        $entry = UserMessage::create([
            'ipaddress' => $ip,
            'message'   => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'data' => $entry
        ]);
    }

}
