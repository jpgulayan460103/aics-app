<?php

namespace App\Http\Controllers;

use App\Models\ServedClient;
use Illuminate\Http\Request;

class ServedClientController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clients = $request->aics_clients;
        // return $clients;
        foreach ($clients as $client) {
            $served_client = ServedClient::whereUuid($client['uuid'])->first();
            if($served_client){
                $served_client->update($client);
            }else{
                $served_client = ServedClient::create($client);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServedClient  $servedClient
     * @return \Illuminate\Http\Response
     */
    public function show(ServedClient $servedClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServedClient  $servedClient
     * @return \Illuminate\Http\Response
     */
    public function edit(ServedClient $servedClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServedClient  $servedClient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServedClient $servedClient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServedClient  $servedClient
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServedClient $servedClient)
    {
        //
    }
}
