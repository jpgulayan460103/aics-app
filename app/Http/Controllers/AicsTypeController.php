<?php

namespace App\Http\Controllers;

use App\Models\AicsType;
use Illuminate\Http\Request;

class AicsTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AicsType::select("id", "name")->with("subtype:id,name,aics_type_id")->get();
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
     * @param  \App\Models\AicsType  $aicsType
     * @return \Illuminate\Http\Response
     */
    public function show(AicsType $aicsType, $id)
    {
        return AicsType::with('requirements')->findOrFail($id);
    }

    public function subtypes(AicsType $aicsType, $id)
    {
        return AicsType::with('subtype')->findOrFail($id);
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AicsType  $aicsType
     * @return \Illuminate\Http\Response
     */
    public function edit(AicsType $aicsType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AicsType  $aicsType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AicsType $aicsType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AicsType  $aicsType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AicsType $aicsType)
    {
        //
    }
}
