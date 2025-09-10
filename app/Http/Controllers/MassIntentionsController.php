<?php

namespace App\Http\Controllers;

use App\Models\MassIntentions;
use App\Http\Requests\StoreMassIntentionsRequest;
use App\Http\Requests\UpdateMassIntentionsRequest;
use Illuminate\Session\Store;

class MassIntentionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
//        try {
            MassIntentions::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Your mass intention has been submitted successfully.'
            ], 200);

//        } catch (\Exception $e) {
//            return response()->json([
//                'success' => false,
//                'message' => 'Something went wrong. Please try again later.'
//            ], 500);
//        }
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
    public function update(UpdateMassIntentionsRequest $request, MassIntentions $massIntentions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MassIntentions $massIntentions)
    {
        //
    }
}
