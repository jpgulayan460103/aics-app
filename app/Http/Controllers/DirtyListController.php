<?php

namespace App\Http\Controllers;

use App\Models\DirtyList;
use Illuminate\Http\Request;

class DirtyListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DirtyList::all();
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
     * @param  \App\Models\DirtyList  $dirtyList
     * @return \Illuminate\Http\Response
     */
    public function show(DirtyList $dirtyList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DirtyList  $dirtyList
     * @return \Illuminate\Http\Response
     */
    public function edit(DirtyList $dirtyList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DirtyList  $dirtyList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DirtyList $dirtyList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DirtyList  $dirtyList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DirtyList::findOrFail($id)->delete();
    }
}
