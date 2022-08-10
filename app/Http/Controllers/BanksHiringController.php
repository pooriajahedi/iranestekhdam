<?php

namespace App\Http\Controllers;

use App\Models\BanksHiring;
use App\Http\Requests\StoreBanksHiringRequest;
use App\Http\Requests\UpdateBanksHiringRequest;

class BanksHiringController extends Controller
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
     * @param  \App\Http\Requests\StoreBanksHiringRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBanksHiringRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BanksHiring  $banksHiring
     * @return \Illuminate\Http\Response
     */
    public function show(BanksHiring $banksHiring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BanksHiring  $banksHiring
     * @return \Illuminate\Http\Response
     */
    public function edit(BanksHiring $banksHiring)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBanksHiringRequest  $request
     * @param  \App\Models\BanksHiring  $banksHiring
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBanksHiringRequest $request, BanksHiring $banksHiring)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BanksHiring  $banksHiring
     * @return \Illuminate\Http\Response
     */
    public function destroy(BanksHiring $banksHiring)
    {
        //
    }
}
