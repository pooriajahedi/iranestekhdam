<?php

namespace App\Http\Controllers;

use App\Models\JobOfferSubmitRequest;
use App\Http\Requests\StoreJobOfferSubmitRequestRequest;
use App\Http\Requests\UpdateJobOfferSubmitRequestRequest;

class JobOfferSubmitRequestController extends Controller
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
     * @param  \App\Http\Requests\StoreJobOfferSubmitRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobOfferSubmitRequestRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobOfferSubmitRequest  $jobOfferSubmitRequest
     * @return \Illuminate\Http\Response
     */
    public function show(JobOfferSubmitRequest $jobOfferSubmitRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobOfferSubmitRequest  $jobOfferSubmitRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(JobOfferSubmitRequest $jobOfferSubmitRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJobOfferSubmitRequestRequest  $request
     * @param  \App\Models\JobOfferSubmitRequest  $jobOfferSubmitRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobOfferSubmitRequestRequest $request, JobOfferSubmitRequest $jobOfferSubmitRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobOfferSubmitRequest  $jobOfferSubmitRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobOfferSubmitRequest $jobOfferSubmitRequest)
    {
        //
    }
}
