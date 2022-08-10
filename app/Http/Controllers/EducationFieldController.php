<?php

namespace App\Http\Controllers;

use App\Models\EducationField;
use App\Http\Requests\StoreEducationFieldRequest;
use App\Http\Requests\UpdateEducationFieldRequest;

class EducationFieldController extends Controller
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
     * @param  \App\Http\Requests\StoreEducationFieldRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEducationFieldRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EducationField  $educationField
     * @return \Illuminate\Http\Response
     */
    public function show(EducationField $educationField)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EducationField  $educationField
     * @return \Illuminate\Http\Response
     */
    public function edit(EducationField $educationField)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEducationFieldRequest  $request
     * @param  \App\Models\EducationField  $educationField
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEducationFieldRequest $request, EducationField $educationField)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EducationField  $educationField
     * @return \Illuminate\Http\Response
     */
    public function destroy(EducationField $educationField)
    {
        //
    }
}
