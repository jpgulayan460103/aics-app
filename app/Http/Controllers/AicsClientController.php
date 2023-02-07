<?php

namespace App\Http\Controllers;

use App\Models\AicsClient;
use Illuminate\Http\Request;

use App\Imports\ClientsImport;
use App\Models\DirtyList;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

class AicsClientController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AicsClient  $aicsClient
     * @return \Illuminate\Http\Response
     */
    public function show(AicsClient $aicsClient, $id)
    {
        $aics_client = $aicsClient->findOrFail($id);
        return $aics_client;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AicsClient  $aicsClient
     * @return \Illuminate\Http\Response
     */
    public function edit(AicsClient $aicsClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AicsClient  $aicsClient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $aics_client = AicsClient::findOrFail($id)->update($request->all());
        return $aics_client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AicsClient  $aicsClient
     * @return \Illuminate\Http\Response
     */
    public function destroy(AicsClient $aicsClient)
    {
        //
    }

    public function client_upload(Request $request)
    {
        $file = request("file");
        $filename = $request->file->getClientOriginalName();
        $year = date("Y");
        $month = date("m");

        $path = Storage::disk('local')->put("public/uploads/dirty_lists/$year/$month",  $file);
        $url = Storage::url($path);

        $dirtylist = new DirtyList([
            'file_directory' => $url,
            'file_name' => $filename,
        ]);

        $dirtylist->save();
        Excel::import(new ClientsImport($dirtylist->id),  $file);
        return redirect('/')->with('success', 'All good!');
    }
}
