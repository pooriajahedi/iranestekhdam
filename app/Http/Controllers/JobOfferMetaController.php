<?php

namespace App\Http\Controllers;

use App\Models\JobOfferMeta;
use App\Http\Requests\StoreJobOfferMetaRequest;
use App\Http\Requests\UpdateJobOfferMetaRequest;

class JobOfferMetaController extends Controller
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
     * @param  \App\Http\Requests\StoreJobOfferMetaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobOfferMetaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobOfferMeta  $jobOfferMeta
     * @return \Illuminate\Http\Response
     */
    public function show(JobOfferMeta $jobOfferMeta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobOfferMeta  $jobOfferMeta
     * @return \Illuminate\Http\Response
     */
    public function edit(JobOfferMeta $jobOfferMeta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJobOfferMetaRequest  $request
     * @param  \App\Models\JobOfferMeta  $jobOfferMeta
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobOfferMetaRequest $request, JobOfferMeta $jobOfferMeta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobOfferMeta  $jobOfferMeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobOfferMeta $jobOfferMeta)
    {
        //
    }
}
