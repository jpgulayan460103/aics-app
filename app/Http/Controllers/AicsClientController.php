<?php

namespace App\Http\Controllers;

use App\Exports\ImportErrors;
use App\Models\AicsClient;
use Illuminate\Http\Request;

use App\Imports\ClientsImport;
use App\Models\DirtyList;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Str;

class AicsClientController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AicsClient  $aicsClient
     * @return \Illuminate\Http\Response
     */
    public function show(AicsClient $aicsClient, $id)
    {
        $aics_client = $aicsClient->findOrFail($id);
        return $aics_client;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AicsClient  $aicsClient
     * @return \Illuminate\Http\Response
     */
    public function edit(AicsClient $aicsClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AicsClient  $aicsClient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $aics_client = AicsClient::findOrFail($id)->update($request->all());
        return $aics_client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AicsClient  $aicsClient
     * @return \Illuminate\Http\Response
     */
    public function destroy(AicsClient $aicsClient)
    {
        //
    }

    public function client_upload(Request $request)
    {
        $validatedData = $request->validate([
            'file' => ['required', 'file', 'max:20000', 'mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,text/csv'],
        ]);
        DB::beginTransaction();
        try {
            $file = request("file");
            $original_filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $filename = $original_filename.".".$file->getClientOriginalExtension();
            $year = date("Y");
            $month = date("m");
    
            $path = Storage::disk('local')->put("public/uploads/dirty_lists/$year/$month",  $file);
            $url = Storage::url($path);
    
            Excel::import(new ClientsImport(),  $file);
            DB::commit();
            return [
                "success" => "All good!",
            ];
            
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            $failures = $e->failures();
     
            $errors = [];

            $errors[] = [
                "file",
                "row",
                "field",
                "value",
                "errors",
            ];
            foreach ($failures as $failure) {
                $values = $failure->values();
                $errors[] = [
                    'file' => $file->getClientOriginalName(),
                    'row' => $failure->row(),
                    'field' => $failure->attribute(),
                    'value' => $values[$failure->attribute()],
                    'errors' => implode("," ,$failure->errors()),
                ];
            }

            $errors_file_name = $original_filename."-errors-".Str::slug(Carbon::now()).".xlsx";
            Excel::store(new ImportErrors($errors), "public/$errors_file_name", 'local');
            return response([
                'errors' => [
                    'file' => ["The file has invalid data."],
                    'errors_file_path' => Storage::path("public/$errors_file_name"),
                ],
                'message' => "The given data was invalid."
            ], 422);
        }
    }
}
