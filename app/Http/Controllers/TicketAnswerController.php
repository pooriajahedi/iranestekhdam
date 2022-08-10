<?php

namespace App\Http\Controllers;

use App\Models\TicketAnswer;
use App\Http\Requests\StoreTicketAnswerRequest;
use App\Http\Requests\UpdateTicketAnswerRequest;

class TicketAnswerController extends Controller
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
     * @param  \App\Http\Requests\StoreTicketAnswerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketAnswerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TicketAnswer  $ticketAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(TicketAnswer $ticketAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TicketAnswer  $ticketAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketAnswer $ticketAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicketAnswerRequest  $request
     * @param  \App\Models\TicketAnswer  $ticketAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketAnswerRequest $request, TicketAnswer $ticketAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TicketAnswer  $ticketAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketAnswer $ticketAnswer)
    {
        //
    }
}
