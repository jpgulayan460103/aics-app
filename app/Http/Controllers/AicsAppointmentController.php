<?php

namespace App\Http\Controllers;

use App\Models\AicsAppointment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AicsAppointmentController extends Controller
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
     * @param  \App\Models\AicsAppointment  $aicsAppointment
     * @return \Illuminate\Http\Response
     */
    public function show(AicsAppointment $aicsAppointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AicsAppointment  $aicsAppointment
     * @return \Illuminate\Http\Response
     */
    public function edit(AicsAppointment $aicsAppointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AicsAppointment  $aicsAppointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AicsAppointment $aicsAppointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AicsAppointment  $aicsAppointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(AicsAppointment $aicsAppointment)
    {
        //
    }

    public function available(Request $request)
    {
        $now = Carbon::now();
        $min_date = $now->clone()->toDateString();
        $max_date = $now->clone()->addWeeks(2)->toDateString();
        $period = CarbonPeriod::create($min_date, $max_date);
        $dates = [];
        foreach ($period as $key => $date) {
            $dates[$key]['date'] = $date->toDateString();
        }
        return [
            "min_date" => $min_date,
            "max_date" => $max_date,
            "dates" => $dates,
        ];
    }
}
