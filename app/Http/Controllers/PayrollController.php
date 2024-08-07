<?php

namespace App\Http\Controllers;

use App\Exports\CoeExport;
use App\Exports\PayrollExport;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Models\Payroll;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\PayrollClient;
use App\Models\Psgc;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Payroll::with("psgc", "aics_type:id,name", "aics_subtype:id,name")->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {

        $validated = $request->validate(
            [
                'title' => 'required',
                'assistance_type' => 'required',
                'amount' => 'required|numeric',
                'sdo' => 'required',
                'psgc_id' => 'required|exists:psgcs,id',
                'approved_by' => 'required',
                'source_of_fund' => 'required',
                'charging' => 'required',
                'status' => 'required',
                'schedule' => 'required|date',
                'aics_type_subcategory_id' => "required|exists:aics_type_subcategories,id"
            ],
            [
                'aics_type_subcategory_id.required' => "Subtype is required"

            ]
        );


        try {
            $p = new Payroll;

            $p->fill($request->toArray());
            $p->title = $request->title;
            $p->aics_type_id  = $request->assistance_type["id"];

            $res = $p->save();

            if ($res) {
                return ["Message" => "Saved"];
            } else {
                return ["Message" => "Failed"];
            }
        } catch (\Throwable $th) {
            return ["Message" => $th];
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
        $payroll = Payroll::with([
            "psgc",
            "clients.aics_client.psgc",
            "clients.aics_client.aics_type",
            "clients.aics_client.subcategory",
            "clients.aics_client.category",
            "clients.new_payroll_client.payroll"
        ])->withTrashed()->find($id);

        if ($payroll) {
            return $payroll;
        } else {
            return ["Message" => "Not Found"];
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
        $validated = $request->validate([
            'title' => 'required',
            'assistance_type' => 'required',
            'amount' => 'required|numeric',
            'sdo' => 'required',
            'psgc_id' => 'required|exists:psgcs,id',
            'approved_by' => 'required',
            'source_of_fund' => 'required',
            'charging' => 'required',
            'status' => 'required',
            'schedule' => 'required|date',
           'aics_type_subcategory_id' => "required|exists:aics_type_subcategories,id"
        ],[
            'aics_type_subcategory_id.required' => "Subtype is required"

        ]);

        $payroll = Payroll::find($request->id);
        if ($payroll) {
            try {

                $payroll->fill($request->toArray());
                $payroll->title = $request->title ? $request->title : $request->assistance_type["name"];
                $payroll->aics_type_id  = $request->assistance_type["id"];

                $payroll->save();
                return ["Message" => "saved"];
            } catch (Exception $e) {
                throw $e;
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
        $payroll = Payroll::with("psgc", "clients")->find($id);
        if ($payroll) {
            return view('pdf.payroll', ["data" => $payroll,  "grand_total" => ($payroll->clients()->count() * $payroll->amount)]);
        };
    }

    public function print_footer($id)
    {
        $payroll = Payroll::with("psgc")->find($id);
        if ($payroll) {
            #return view('pdf.payroll', ["data" => $payroll]);


            $pdf = Pdf::loadView('pdf.payroll_footer', ["data" => $payroll]);
            return $pdf->setPaper('a4', 'landscape')->stream('payroll.pdf');
        };
    }

    public function printv2($id)
    {
        $payroll_clients = Payroll::find($id)->clients()->withTrashed()->paginate(10);
        $payroll_clients->load('new_payroll_client.payroll');

        $payroll = Payroll::with("psgc")->find($id);

        if ($payroll) {

            $total_clients = Payroll::find($id)->clients()->count();

            abort_unless($payroll_clients->count(), 204);


            $pdf = Pdf::loadView(
                'pdf.payrollv2',
                [
                    "clients" => $payroll_clients,
                    "payroll" => $payroll,
                    "grand_total" => $total_clients * $payroll->amount,
                ]
            );
            return $pdf->setPaper('a4', 'landscape')->stream('payroll.pdf');

            //return view('pdf.payrollv2', ["data" => $payroll]);
        }
    }

    public function print_coe(Request $request, $id)
    {
        $payroll_clients = PayrollClient::query()->with([
            'aics_client',
            'aics_client.psgc',
            'aics_client.aics_type',
            'aics_client.subcategory',
            'aics_client.category',
        ])
            ->where('payroll_id', $id)
            ->where('status', 'claimed')
            ->orderBy('sequence', "asc")
            ->get();


        $payroll = Payroll::with("psgc")->find($id);

        if ($payroll) {

            abort_unless($payroll_clients->count(), 204);
            $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
            $data = [
                "clients" => $payroll_clients,
                "payroll" => $payroll,
                "in_words" => strtoupper($f->format($payroll_clients->count())),
            ];
            if ($request->ext && $request->ext == "xlsx") {
                $file_ext = ".xlsx";
                $export_file_name = "aics-online-app-coe-" . Str::slug(Carbon::now()) . $file_ext;
                return Excel::download(new CoeExport($data), $export_file_name);
            } else {
                $file_ext = ".pdf";
                $export_file_name = "aics-online-app-coe-" . Str::slug(Carbon::now()) . $file_ext;
                $pdf = Pdf::loadView('pdf.coe', $data);
                return $pdf->setPaper('portrait')->download($export_file_name);
            }
        }
    }

    public function print_coe_single(Request $request, $id)
    {
        $payroll_clients = PayrollClient::query()->with([
            'aics_client',
            'aics_client.psgc',
            'aics_client.aics_type',
            'aics_client.subcategory',
            'aics_client.category',
        ])
            ->where('payroll_id', $id)
            ->where('status', 'claimed')
            ->orderBy('sequence', "asc")
            ->get();


        $payroll = Payroll::with("psgc")->find($id);

        if ($payroll) {

            abort_unless($payroll_clients->count(), 204);
            $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
            $data = [
                "clients" => $payroll_clients,
                "payroll" => $payroll,
                "in_words" => strtoupper($f->format($payroll_clients->count())),
            ];

            $file_ext = ".pdf";
            $export_file_name = "aics-online-app-coe-" . Str::slug(Carbon::now()) . $file_ext;
            $pdf = Pdf::loadView('pdf.coe-single', $data);
            return $pdf->setPaper('portrait')->download($export_file_name);
        }
    }



    public function export(Request $request, $payroll_id)
    {
        $payroll = Payroll::findOrFail($payroll_id);
        $filename = "";
        $filename .= Str::slug($payroll->title) . "-";
        $filename .= Str::slug($payroll->charging) . "-";
        $filename .= Str::slug($payroll->sdo) . "-";
        $filename .= Str::slug($payroll->amount) . "-";
        $filename .= Str::slug(Carbon::now());
        $export_file_name = "$filename.xlsx";
        Excel::store(new PayrollExport($payroll, $request->status), "public/$export_file_name", 'local');
        return [
            "file" => url(Storage::url("public/$export_file_name")),
        ];
    }

    public function active_payrolls()
    {
        return Payroll::whereNull("status")
            ->with("aics_type:id,name", "aics_subtype:id,name")
            ->orWhere("status", "active")
            ->get();
    }

   
    
}
