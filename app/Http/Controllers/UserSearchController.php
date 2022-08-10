<?php

namespace App\Http\Controllers;

use App\Models\UserSearch;
use App\Http\Requests\StoreUserSearchRequest;
use App\Http\Requests\UpdateUserSearchRequest;

class UserSearchController extends Controller
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
     * @param  \App\Http\Requests\StoreUserSearchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserSearchRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserSearch  $userSearch
     * @return \Illuminate\Http\Response
     */
    public function show(UserSearch $userSearch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserSearch  $userSearch
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSearch $userSearch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserSearchRequest  $request
     * @param  \App\Models\UserSearch  $userSearch
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserSearchRequest $request, UserSearch $userSearch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserSearch  $userSearch
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSearch $userSearch)
    {
        //
    }
}
