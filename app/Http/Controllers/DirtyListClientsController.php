<?php

namespace App\Http\Controllers;

use App\Models\DirtyListClients;
use Illuminate\Http\Request;

class DirtyListClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DirtyListClients::all();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DirtyListClients  $dirtyListClients
     * @return \Illuminate\Http\Response
     */
    public function show(DirtyListClients $dirtyListClients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DirtyListClients  $dirtyListClients
     * @return \Illuminate\Http\Response
     */
    public function edit(DirtyListClients $dirtyListClients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DirtyListClients  $dirtyListClients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DirtyListClients $dirtyListClients)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DirtyListClients  $dirtyListClients
     * @return \Illuminate\Http\Response
     */
    public function destroy(DirtyListClients $dirtyListClients)
    {
        //
    }
}
