<?php

namespace App\Http\Controllers;

use App\Models\AicsBeneficiary;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class AicsBeneficiaryController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AicsBeneficiary  $aicsBeneficiary
     * @return \Illuminate\Http\Response
     */
    public function show(AicsBeneficiary $aicsBeneficiary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AicsBeneficiary  $aicsBeneficiary
     * @return \Illuminate\Http\Response
     */
    public function edit(AicsBeneficiary $aicsBeneficiary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AicsBeneficiary  $aicsBeneficiary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AicsBeneficiary $aicsBeneficiary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AicsBeneficiary  $aicsBeneficiary
     * @return \Illuminate\Http\Response
     */
    public function destroy(AicsBeneficiary $aicsBeneficiary)
    {
        //
    }

    public function getCategories()
    {
        return ["categories"=>Category::all(), "subcategory"=> Subcategory::all()];
        
    }
}
