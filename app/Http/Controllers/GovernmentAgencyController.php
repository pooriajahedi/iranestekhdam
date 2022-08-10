<?php

namespace App\Http\Controllers;

use App\Models\GovernmentAgency;
use App\Http\Requests\StoreGovernmentAgencyRequest;
use App\Http\Requests\UpdateGovernmentAgencyRequest;

class GovernmentAgencyController extends Controller
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
     * @param  \App\Http\Requests\StoreGovernmentAgencyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGovernmentAgencyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GovernmentAgency  $governmentAgency
     * @return \Illuminate\Http\Response
     */
    public function show(GovernmentAgency $governmentAgency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GovernmentAgency  $governmentAgency
     * @return \Illuminate\Http\Response
     */
    public function edit(GovernmentAgency $governmentAgency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGovernmentAgencyRequest  $request
     * @param  \App\Models\GovernmentAgency  $governmentAgency
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGovernmentAgencyRequest $request, GovernmentAgency $governmentAgency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GovernmentAgency  $governmentAgency
     * @return \Illuminate\Http\Response
     */
    public function destroy(GovernmentAgency $governmentAgency)
    {
        //
    }
}
