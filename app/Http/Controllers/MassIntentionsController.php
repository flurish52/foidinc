<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\MassIntentions;
use App\Http\Requests\StoreMassIntentionsRequest;
use App\Http\Requests\UpdateMassIntentionsRequest;
use Egulias\EmailValidator\Result\Reason\ConsecutiveAt;
use http\Exception\InvalidArgumentException;
use Illuminate\Session\Store;
use Inertia\Inertia;

class MassIntentionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia::render('MassIntentions', [
           'massIntentions' => MassIntentions::latest()->paginate(10) ?? null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMassIntentionsRequest $request)
    {
        try {
            MassIntentions::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Your mass intention has been submitted successfully.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MassIntentions $massIntentions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MassIntentions $massIntentions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMassIntentionsRequest $request)
    {
        $validated = $request->validate([
            'intentionId' => 'required|exists:mass_intentions,id',
            'status' => 'required|in:pending,approved,rejected,fulfilled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $intention = MassIntentions::findOrFail($validated['intentionId']);
        $intention->update([
            'status' => $validated['status'],
            'note' => $validated['notes'],
        ]);

        return response()->json([
            'message' => 'Mass intention updated successfully',
            'data' => $intention,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $intention = \App\Models\MassIntentions::findOrFail($id);
        $intention->delete();

        return response()->json(['message' => 'Mass intention deleted successfully']);
    }
}
