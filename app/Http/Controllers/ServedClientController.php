<?php

namespace App\Http\Controllers;

use App\Imports\ServedClientsImport;
use App\Models\ServedClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use App\Exports\ImportErrors;
use App\Models\AicsClient;
use Illuminate\Support\Facades\Storage;

class ServedClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        DB::enableQueryLog();
        $date_from = Carbon::now()->clone()->subMonth(3);
        $date_to = Carbon::now()->clone();
        $clients = ServedClient::with("psgc");
        if($request->search){
            $search = $request->search;
            $keywords = explode(" ", $search);
            $clients->where(function ($main_query) use ($keywords){
                $main_query->where(function($sub_query) use ($keywords){
                    foreach ($keywords as $keyword) {
                        $sub_query->where("full_name" , "like", "%$keyword%");
                    }
                });
                $main_query->orWhere(function($sub_query) use ($keywords){
                    foreach ($keywords as $keyword) {
                        $sub_query->where("meta_full_name" , "like", "%".metaphone($keyword)."%");
                    }
                });
            });

        }
        $clients->whereBetween('date_claimed', [
            $date_from,
            $date_to->addDay()->subSecond(),
        ]);
        $clients->orderBy('first_name');
        $clients->orderBy('middle_name');
        $clients->orderBy('last_name');
        $clients = $clients->paginate(20);
        return [
            'clients' => $clients,
            'date_from' => $date_from->format("F d, Y"),
            'date_to' => $date_to->format("F d, Y"),
            'query' => DB::getQueryLog()
        ];
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
        $clients = $request->aics_clients;
        // return $clients;
        foreach ($clients as $client) {
            $served_client = ServedClient::whereUuid($client['uuid'])->first();
            if($served_client){
                $served_client->update($client);
            }else{
                $served_client = ServedClient::create($client);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServedClient  $servedClient
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {   
       $client =  ServedClient::with("served_client_metas","psgc")->where("uuid", "=" ,$uuid)->firstOrFail();

        return $client;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServedClient  $servedClient
     * @return \Illuminate\Http\Response
     */
    public function edit(ServedClient $servedClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServedClient  $servedClient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServedClient $servedClient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServedClient  $servedClient
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServedClient $servedClient)
    {
        //
    }

    public function upload(Request $request)
    {   
        $file = request("file");
        $original_filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = $original_filename . "-" . Str::slug(Carbon::now()) . "." . $file->getClientOriginalExtension();
        $year = date("Y");
        $month = date("m");

        $validatedData = $request->validate([
            'file' => ['required', 'file', 'max:20000', 'mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,text/csv'],
        ]);
        \DB::beginTransaction();
        try {
            $file = request("file");
           /* $original_filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $filename = $original_filename . "-" . Str::slug(Carbon::now()) . "." . $file->getClientOriginalExtension();
            $year = date("Y");
            $month = date("m");

            // $path = Storage::disk('local')->put("public/uploads/dirty_lists/$year/$month",  $file);
            $path = Storage::disk('local')->putFileAs("public/uploads/dirty_lists/$year/$month", $file, $filename);
            $url = Storage::url($path);

            $dirtylist = DirtyList::create([
                'file_directory' => $url,
                'file_name' => $filename,
            ]);*/

            Excel::import(new ServedClientsImport($file),  $file, 'UTF-8');
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
                    'value' => isset($values[$failure->attribute()]) ? $values[$failure->attribute()] : '' ,
                    'errors' => implode(",", $failure->errors()),
                ];
            }

            $errors_file_name = $original_filename . "-errors-" . Str::slug(Carbon::now()) . ".xlsx";
            Excel::store(new ImportErrors($errors), "public/$errors_file_name", 'local');


            return response([
                'errors' => [
                    'file' => ["The file has invalid data."],
                    'errors_file_path' => url(Storage::url("public/$errors_file_name")),
                ],
                'message' => "The given data was invalid."
            ], 422);
        }
    }

    public function export(Request $request)
    {
        $filename = "";
        $filename .= "aics-served-clients-";
        $filename .= Str::slug(Carbon::now());
        $export_file_name = "$filename.xlsx";
        Excel::store(new ServedClientsExport(), "public/$export_file_name", 'local');
        return [
            "file" => url(Storage::url("public/$export_file_name")),
        ];
    }


}
