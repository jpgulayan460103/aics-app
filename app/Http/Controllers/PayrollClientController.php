<?php

namespace App\Http\Controllers;

use App\Models\AicsClient;
use App\Models\AicsType;
use App\Models\Category;
use App\Models\Disabilites;
use App\Models\Payroll;
use App\Models\PayrollClient;
use App\Models\Subcategory;
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
        \DB::beginTransaction();
        try {
            $payroll_client = PayrollClient::findOrFail($id);
            if ($payroll_client->update($request->all())) {
                \DB::commit();
              
                return ["message" => "saved"];
            };
        } catch (\Throwable $th) {
            \DB::rollBack();
            throw $th;
        }
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

    public function print_attestation_multiple(Request $request, $id)
    {
        $page = $request->page ? $request->page : 1;
        $aics_client_ids = PayrollClient::where('payroll_id', $id)->withTrashed()->offset(($page - 1) * 10)->limit(10)->pluck('aics_client_id');
        $payroll = Payroll::with("aics_type", "aics_subtype")->findOrFail($id);
               
        $clients =  AicsClient::withTrashed()->with([
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
            
            $pdf = Pdf::loadView(
                'pdf.attestation',
                [
                    "clients" => $clients->toArray(),
                    "assistance_type" => $payroll->aics_type ? $payroll->aics_type->name : $payroll->title,
                ]
            );
            return $pdf->setPaper('a4', 'portrait')->stream('attestation.pdf');
        }
    }

    public function print_attestation_single(Request $request, $id)
    {
        $clients =  AicsClient::withTrashed()->with([
            "psgc",
            "aics_type",
            "payroll_client.payroll",
            "category",
            "subcategory"
        ])
            ->whereIn("aics_clients.id", $request->ids)
            ->select("aics_clients.*")
            ->orderBy('payroll_clients.sequence')
            ->join('payroll_clients', function ($join) use ($id) {
                $join->on("aics_clients.id", "=", "payroll_clients.aics_client_id")->where('payroll_id', $id);
            })
            ->get();

        $payroll = Payroll::with("aics_type", "aics_subtype")->findOrFail($id);
        
        // Split the subcategories into short and long groups
            
        if ($clients) {
            
            $pdf = Pdf::loadView(
                'pdf.attestation',
                [
                    "clients" => $clients->toArray(),
                    "aics_beneficiaries" =>  $clients->filter(function ($client, $key) {
                        return $client->payroll_client;
                    })->toArray(),
                    "assistance_type" => $payroll->aics_type ? $payroll->aics_type->name : $payroll->title,
                ]
            );
            return $pdf->setPaper('a4', 'portrait')->stream('attestation.pdf');
        }
    }

    public function printv2(Request $request, $id)
    {
        $page = $request->page ? $request->page : 1;
        $aics_client_ids = PayrollClient::where('payroll_id', $id)->withTrashed()->offset(($page - 1) * 10)->limit(10)->pluck('aics_client_id');
        $payroll = Payroll::with("aics_type", "aics_subtype")->findOrFail($id);
        $categories  = Category::all()->pluck("category");
        $disabilities = Disabilites::all()->pluck("disability");
    
        $subcategories  = Subcategory::orderByRaw("
        CASE 
        WHEN subcategory = 'Minimum Wage Earner' THEN 1 
        WHEN subcategory = 'others' THEN 3
        ELSE 0 
    END ASC,
    LENGTH(subcategory) ASC
    ")->where("subcategory", "!=", "None of the above")->pluck("subcategory");

        // Split the subcategories into short and long groups
        $midPoint = ceil($subcategories->count() / 2);
        $shortSubcategories = $subcategories->slice(0, $midPoint);
        $longSubcategories = $subcategories->slice($midPoint);


        $assistance_options = AicsType::all()->pluck("name")->map(function ($e) {
            $x = explode(" ", $e);
            return $x[0];
        });

       
        $clients =  AicsClient::withTrashed()->with([
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

            $pdf = Pdf::loadView(
                'pdf.gis_many',
                [
                    "aics_beneficiaries" =>  $clients->filter(function ($client, $key) {
                        return $client->payroll_client;
                    })->toArray(),
                    "assistance_type" => $payroll->aics_type ? $payroll->aics_type->name : $payroll->title,
                    "approved_by" => $payroll->approved_by,
                    "categories" =>  $categories,
                    #  "subcategories" =>  $subcategories,
                    "subcategories" =>  compact('shortSubcategories', 'longSubcategories'),
                    "assistance_options" => $assistance_options,
                    "assistance_type_subcategory" => $payroll->aics_subtype ? $payroll->aics_subtype->name : "Daily Consumption and Other Needs",
                    "disabilities"=>  $disabilities,
    
                ]
            );

            /*return view('pdf.gis_many',  [
                "aics_beneficiaries" =>  $clients->filter(function ($client, $key) {
                    return $client->payroll_client;
                })->toArray(),
                "assistance_type" => $payroll->aics_type->name,
                "approved_by" => $payroll->approved_by,
                "categories" =>  $categories,
                "subcategories" =>  $subcategories,
            ]);*/

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

        $client =  AicsClient::withTrashed()->with([
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
            "Laboratory Request",
            "Social Case Study Report",
            "Justification",
            "Prescriptions",
            "Promisory Note",
            "Contract of Employment",
            "Valid ID Presented",
            "Statement of Account",
            "Funeral Contract",
            "Certificate of Employment",
            "______________________",
            "Treatment Protocol",
            "Death Certificate",
            "Income Tax Return",
            "",
            "Quotation/Chargeslip",
            "Death Summary",
            "Others",
            "",
            "Discharge Summary",
            "Referral Letter",


        ];

        $assistance_options = [
            "Medical Assistance",
            "Transportation Assistance",
            "Food Assistance",
            "Funeral Assistance",
            "Educational Assistance",
            "Cash Relief Assistance",
            "Emergency Cash Transfer"
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
    }

    public function qr_codes(Request $request, $id)
    {
        //\QRcode::png("1323", "samok.png");


        $page = $request->page ? $request->page : 1;
        $aics_client_ids = PayrollClient::where('payroll_id', $id)->withTrashed()->offset(($page - 1) * 10)->limit(10)->pluck('aics_client_id');

        $client =  AicsClient::withTrashed()->with([
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

        $payroll = Payroll::with("aics_type", "aics_subtype", "psgc")->findOrFail($id);
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

        $record_options = [
            "General Intake Sheet",
            "Medical Certificate/Abstract",
            "Laboratory Request",
            "Social Case Study Report",
            "Justification",
            "Prescriptions",
            "Promisory Note",
            "Contract of Employment",
            "Valid ID Presented",
            "Statement of Account",
            "Funeral Contract",
            "Certificate of Employment",
            "______________________",
            "Treatment Protocol",
            "Death Certificate",
            "Income Tax Return",
            "",
            "Quotation/Chargeslip",
            "Death Summary",
            "Others",
            "",
            "Discharge Summary",
            "Referral Letter",


        ];

        $assistance_options = [
            "Medical Assistance",
            "Transportation Assistance",
            "Food Assistance",
            "Funeral Assistance",
            "Educational Assistance",
            "Cash Relief Assistance",
            "Emergency Cash Transfer"
        ];

        # $assistance_options =  AicsType::all()->pluck("name");

        $clients =  $client->toArray();



        if ($client) {
            /*$pdf = Pdf::loadView(
                'pdf.qr_codes',
                [
                    "aics_beneficiaries" =>  $clients,
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
            );*/
            // return $pdf->stream('coe.pdf');

            return view('pdf.qr_codes', [
                "aics_beneficiaries" =>  $clients,
                "SDO" => $payroll->sdo,
                "amount_in_words" => $f->format($payroll->amount),
                "approved_by" => $payroll->approved_by,
                "amount" => $payroll->amount,
                "record_options" => $record_options,
                # "cav_assistance_options" => $cav_assistance_options,
                "assistance_options" => $assistance_options,
                "assistance_type" => isset($payroll->aics_type) ?  $payroll->aics_type->name : "",
                "assistance_type_subcategory" => isset($payroll->aics_subtype) ?  $payroll->aics_subtype->name : "",
                "venue" => isset($payroll->psgc) ? $payroll->psgc->brgy_name . ", " . $payroll->psgc->city_name . ", " . $payroll->psgc->province_name : "",
            ]);
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
