<?php

namespace App\Http\Controllers;

use App\Models\AicsTypeSubcategory;
use Illuminate\Http\Request;

class AicsTypeSubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AicsTypeSubcategory::all();
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
     * @param  \App\Models\AicsTypeSubcategory  $aicsTypeSubcategory
     * @return \Illuminate\Http\Response
     */
    public function show(AicsTypeSubcategory $aicsTypeSubcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AicsTypeSubcategory  $aicsTypeSubcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(AicsTypeSubcategory $aicsTypeSubcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AicsTypeSubcategory  $aicsTypeSubcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AicsTypeSubcategory $aicsTypeSubcategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AicsTypeSubcategory  $aicsTypeSubcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(AicsTypeSubcategory $aicsTypeSubcategory)
    {
        //
    }
}
