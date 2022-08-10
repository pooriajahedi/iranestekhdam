<?php

namespace App\Http\Controllers;

use App\Models\UserAutomaticSubscription;
use App\Http\Requests\StoreUserAutomaticSubscriptionRequest;
use App\Http\Requests\UpdateUserAutomaticSubscriptionRequest;

class UserAutomaticSubscriptionController extends Controller
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
     * @param  \App\Http\Requests\StoreUserAutomaticSubscriptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserAutomaticSubscriptionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAutomaticSubscription  $userAutomaticSubscription
     * @return \Illuminate\Http\Response
     */
    public function show(UserAutomaticSubscription $userAutomaticSubscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserAutomaticSubscription  $userAutomaticSubscription
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAutomaticSubscription $userAutomaticSubscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserAutomaticSubscriptionRequest  $request
     * @param  \App\Models\UserAutomaticSubscription  $userAutomaticSubscription
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserAutomaticSubscriptionRequest $request, UserAutomaticSubscription $userAutomaticSubscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAutomaticSubscription  $userAutomaticSubscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAutomaticSubscription $userAutomaticSubscription)
    {
        //
    }
}
