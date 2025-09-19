<?php

namespace App\Http\Controllers;

use App\Models\PrayerRequest;
use Illuminate\Http\Request;

class PrayerRequestController extends Controller
{


    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'prayer_request' => 'required|string',
        ]);
        $data['status'] =  'pending';

        PrayerRequest::create($data);

        return response()->json([
            'message' => 'Your prayer request has been submitted successfully.'
        ]);
    }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'prayerRequest' => 'required|exists:prayer_requests,id',
            'status' => 'required|in:pending,approved,rejected,fulfilled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $prayerRequest = PrayerRequest::findOrFail($validated['prayerRequest']);
        $prayerRequest->update([
            'status' => $validated['status'],
            'note' => $validated['notes'],
        ]);
        $prayerRequest->save();

        return response()->json([
            'message' => 'Mass intention updated successfully',
            'data' => $prayerRequest,
        ]);
    }

}
