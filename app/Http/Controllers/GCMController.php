<?php

namespace App\Http\Controllers;

use App\Models\GCM;
use App\Http\Requests\StoreGCMRequest;
use App\Http\Requests\UpdateGCMRequest;

class GCMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGCMRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGCMRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GCM  $gCM
     * @return \Illuminate\Http\Response
     */
    public function show(GCM $gCM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GCM  $gCM
     * @return \Illuminate\Http\Response
     */
    public function edit(GCM $gCM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGCMRequest  $request
     * @param  \App\Models\GCM  $gCM
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGCMRequest $request, GCM $gCM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GCM  $gCM
     * @return \Illuminate\Http\Response
     */
    public function destroy(GCM $gCM)
    {
        //
    }
}
