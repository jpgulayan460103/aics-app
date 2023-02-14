<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Payroll::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {
        try {
            $p = new Payroll;
            $p->fill($request->toArray());
            $res = $p->save();
            if ($res) {
                return ["Message" => "Saved"];
            } else {
                return ["Message" => "Failed"];
            }
        } catch (\Throwable $th) {
            return ["Message"=>$th];
        }
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
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payroll = Payroll::find($id)->with("clients")->get();
        if($payroll)
        {
            return $payroll;
        }else
        {
            return ["Message"=>"Not Found"];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function edit(Payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payroll $payroll)
    {
        $payroll = Payroll::find($request->id);
        if ($payroll) {
            try {

                $payroll->fill($request->toArray());
                $payroll->save();
                return ["Message" => "saved"];
            } catch (Exception $e) {
                return ["Message" => $e];
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request)
    {
        try {
            $payroll = Payroll::find($request->id);
            if ($payroll) {
                $payroll->delete();
                return ["Message" => "Deleted"];
            } else {
                return ["Message" => "Not Found"];
            }
        } catch (Exception $e) {
            return ["Message" => $e];
        }
    }

    public function print($id)
    {
        $payroll = Payroll::with("psgc")->find($id);
        if($payroll)
        {
            #return view('pdf.payroll', ["data" => $payroll]);
       

            $pdf = Pdf::loadView('pdf.payroll', ["data" => $payroll]);
            return $pdf->setPaper('a4', 'landscape')->stream('payroll.pdf');

        };
    }

}
