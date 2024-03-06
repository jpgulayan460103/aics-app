<?php

namespace App\Http\Controllers;

use App\Models\AicsClient;
use App\Models\AicsType;
use App\Models\Payroll;
use App\Models\PayrollClient;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use \NumberFormatter;

class PayrollClientController extends Controller
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
     * @param  \App\Models\PayrollClient  $payrollClient
     * @return \Illuminate\Http\Response
     */
    public function show(PayrollClient $payrollClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PayrollClient  $payrollClient
     * @return \Illuminate\Http\Response
     */
    public function edit(PayrollClient $payrollClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PayrollClient  $payrollClient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payroll_client = PayrollClient::findOrFail($id);
        $payroll_client->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PayrollClient  $payrollClient
     * @return \Illuminate\Http\Response
     */
    public function destroy(PayrollClient $payrollClient)
    {
        //
    }

    public function printv2(Request $request, $id)
    {
        $page = $request->page ? $request->page : 1;
        $aics_client_ids = PayrollClient::where('payroll_id', $id)->withTrashed()->offset(($page - 1) * 10)->limit(10)->pluck('aics_client_id');

        // dd($aics_client_ids);


        $clients =  AicsClient::with([
            "psgc",
            "aics_type",
            "payroll_client.payroll",
            "category",
            "subcategory"
        ])
            ->whereIn("aics_clients.id", $aics_client_ids)
            ->select("aics_clients.*")
            ->orderBy('payroll_clients.sequence')
            ->join('payroll_clients', function ($join) use ($id) {
                $join->on("aics_clients.id", "=", "payroll_clients.aics_client_id")->where('payroll_id', $id);
            })
            ->get();
        if ($clients) {
            $pdf = Pdf::loadView('pdf.gis_many', ["aics_beneficiaries" =>  $clients->filter(function ($client, $key) {
                return $client->payroll_client;
            })->toArray()]);
            return $pdf->stream('gis.pdf');
        }
        return $clients;
    }

    public function setAllClaimed(Request $request, $id)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->clients()->update([
            'status' => 'claimed',
            'date_claimed' => Carbon::now()->toDateString(),
        ]);
    }

    public function page_coe(Request $request, $id)
    {
        $page = $request->page ? $request->page : 1;
        $aics_client_ids = PayrollClient::where('payroll_id', $id)->withTrashed()->offset(($page - 1) * 10)->limit(10)->pluck('aics_client_id');

        $client =  AicsClient::with([
            "psgc",
            "aics_type",
            "payroll_client.payroll",
            "category",
            "subcategory"
        ])
            ->whereIn("aics_clients.id",  $aics_client_ids)
            ->select("aics_clients.*")
            ->orderBy('payroll_clients.sequence')
            ->join('payroll_clients', function ($join) use ($id) {
                $join->on("aics_clients.id", "=", "payroll_clients.aics_client_id")->where('payroll_id', $id);
            })
            ->get();

        $payroll = Payroll::with("aics_type", "aics_subtype")->findOrFail($id);
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

        $record_options = [
            "General Intake Sheet",
            "Medical Certificate/Abstract",
            "Discharge Summary",
            "Death Summary",
            "Valid ID Presented",
            "Prescriptions",
            "Laboratory Request",
            "Referral Letter",
            "______________________",
            "Statement of Account",
            "Charge Slip",
            "Social Case Study Report",
            "4PS DSWD ID",
            "Treatment Protocol",
            "Funeral Contract",
            "Others",
            "Justification",
            "Quotation",
            "Death Certificate",
        ];

        $assistance_options = [
            "Medical Assistance",
            "Transportation Assistance",
            "Food Assistance",
            "Funeral Assistance",
            "Education Assistance",
            "Cash Assistance for Support Services"
        ];

       # $assistance_options =  AicsType::all()->pluck("name");

        if ($client) {
            $pdf = Pdf::loadView(
                'pdf.coe_batch',
                [
                    "aics_beneficiaries" =>  $client->toArray(),
                    "SDO" => $payroll->sdo,
                    "amount_in_words" => $f->format($payroll->amount),
                    "approved_by" => $payroll->approved_by,
                    "amount" => $payroll->amount,
                    "record_options" => $record_options,
                    # "cav_assistance_options" => $cav_assistance_options,
                    "assistance_options" => $assistance_options,
                    "assistance_type" => isset($payroll->aics_type) ?  $payroll->aics_type->name : "",
                    "assistance_type_subcategory" => isset($payroll->aics_subtype) ?  $payroll->aics_subtype->name : "",
                ]
            );
            return $pdf->stream('coe.pdf');
        }

        /*$clients =  AicsClient::with([
            "psgc",
            "aics_type",
            "payroll_client.payroll",
            "category",
            "subcategory"
        ])
            ->whereIn("aics_clients.id", $aics_client_ids)
            ->select("aics_clients.*")
            ->orderBy('payroll_clients.sequence')
            ->join('payroll_clients', function ($join) use ($id) {
                $join->on("aics_clients.id", "=","payroll_clients.aics_client_id")->where('payroll_id', $id);
            })
            ->get();
        if ($clients) {
            $pdf = Pdf::loadView('pdf.gis_many', ["aics_beneficiaries" =>  $clients->filter(function ($client, $key) {
                return $client->payroll_client;
            })->toArray()]);
            return $pdf->stream('gis.pdf');

        }
        return $clients;*/
    }
}
