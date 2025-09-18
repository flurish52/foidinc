<?php

namespace App\Http\Controllers;

use App\Models\Route_link;
use App\Http\Requests\StoreRoute_linkRequest;
use App\Http\Requests\UpdateRoute_linkRequest;
use Illuminate\Routing\Route;
use Inertia\Inertia;

class RouteLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function contactUs()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoute_linkRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Route_link $route_link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Route_link $route_link)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoute_linkRequest $request, Route_link $route_link)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route_link $route_link)
    {
        //
    }
}
