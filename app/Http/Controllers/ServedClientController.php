<?php

namespace App\Http\Controllers;

use App\Models\ServedClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServedClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        DB::enableQueryLog();
        $date_from = Carbon::now()->clone()->subMonth(3);
        $date_to = Carbon::now()->clone();
        $clients = ServedClient::with("psgc");
        if($request->search){
            $search = $request->search;
            $keywords = explode(" ", $search);
            $clients->where(function ($main_query) use ($keywords){
                $main_query->where(function($sub_query) use ($keywords){
                    foreach ($keywords as $keyword) {
                        $sub_query->where("full_name" , "like", "%$keyword%");
                    }
                });
                $main_query->orWhere(function($sub_query) use ($keywords){
                    foreach ($keywords as $keyword) {
                        $sub_query->where("meta_full_name" , "like", "%".metaphone($keyword)."%");
                    }
                });
            });

        }
        $clients->whereBetween('date_claimed', [
            $date_from,
            $date_to->addDay()->subSecond(),
        ]);
        $clients->orderBy('first_name');
        $clients->orderBy('middle_name');
        $clients->orderBy('last_name');
        $clients = $clients->paginate(20);
        return [
            'clients' => $clients,
            'date_from' => $date_from->format("F d, Y"),
            'date_to' => $date_to->format("F d, Y"),
            'query' => DB::getQueryLog()
        ];
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
