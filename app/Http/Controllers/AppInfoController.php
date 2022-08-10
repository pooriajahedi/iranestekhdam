<?php

namespace App\Http\Controllers;

use App\Models\AppInfo;
use App\Http\Requests\StoreAppInfoRequest;
use App\Http\Requests\UpdateAppInfoRequest;

class AppInfoController extends Controller
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
     * @param  \App\Http\Requests\StoreAppInfoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppInfoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AppInfo  $appInfo
     * @return \Illuminate\Http\Response
     */
    public function show(AppInfo $appInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AppInfo  $appInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(AppInfo $appInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAppInfoRequest  $request
     * @param  \App\Models\AppInfo  $appInfo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppInfoRequest $request, AppInfo $appInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AppInfo  $appInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppInfo $appInfo)
    {
        //
    }
}
