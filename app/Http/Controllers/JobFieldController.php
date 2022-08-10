<?php

namespace App\Http\Controllers;

use App\Models\JobField;
use App\Http\Requests\StoreJobFieldRequest;
use App\Http\Requests\UpdateJobFieldRequest;

class JobFieldController extends Controller
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
     * @param  \App\Http\Requests\StoreJobFieldRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobFieldRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobField  $jobField
     * @return \Illuminate\Http\Response
     */
    public function show(JobField $jobField)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobField  $jobField
     * @return \Illuminate\Http\Response
     */
    public function edit(JobField $jobField)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJobFieldRequest  $request
     * @param  \App\Models\JobField  $jobField
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobFieldRequest $request, JobField $jobField)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobField  $jobField
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobField $jobField)
    {
        //
    }
}
