<?php

namespace App\Http\Controllers;

use App\Models\AicsClient;
use App\Models\Payroll;
use App\Models\PayrollClient;
use Illuminate\Http\Request;
use Zxing\QrReader;

class QRCodesController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // \QRcode::png($reference_no, $qrcode);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function decode(Request $request)
    {
        $request->validate([
            'qr_code_image' => 'required|image'
        ]);

        $file = $request->file('qr_code_image');
        $path = $file->getRealPath();

        $qrcode = new QrReader($path);
        $text = $qrcode->text();

        return response()->json(['decoded_text' => $text]);
    }

    public function search(Request $request)
    {   
        


        $request->validate([
            'payroll_id' => 'required|numeric|exists:payrolls,id',
            'aics_client_id' => 'required|numeric|exists:aics_clients,id'
        ], [
            'payroll_id.required' => 'The payroll ID is required.',
            'payroll_id.numeric' => 'The payroll ID must be a number.',
            'payroll_id.exists' => 'The selected payroll ID does not exist in this server.',
            'aics_client_id.required' => 'The AICS client ID is required.',
            'aics_client_id.numeric' => 'The AICS client ID must be a number.',
            'aics_client_id.exists' => 'The selected AICS client ID does not exist in this server.'
        ]);


        try {
            if (isset($request->payroll_id) && $request->aics_client_id) {
                return PayrollClient::with(["aics_client" => function ($query) {
                  
                    $query->withTrashed()->with("psgc");
                }, "payroll"  => function ($query) {
                    
                    $query->withTrashed()->with("psgc");
                }])
                    ->where("payroll_id", "=",  $request->payroll_id)
                    ->where("aics_client_id", "=", $request->aics_client_id)
                    ->firstOrFail() ;
                   
            };
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
