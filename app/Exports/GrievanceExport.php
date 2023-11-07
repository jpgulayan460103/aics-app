<?php

namespace App\Exports;

use App\Models\AicsClient;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;

class GrievanceExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable, RemembersRowNumber;


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collection =  AicsClient::query()->with([
            'psgc',
            'aics_type',
            'subcategory',
            'category',
            'user',
            'dirty_list',
        ])->where("is_verified", "=", "grievance");

        $collection = $collection->orderBy("updated_at","desc")->get()->transform(function($client){
            $client->activity =  Activity::forSubject($client)
                ->select("properties")
                ->orderBy("created_at","desc")
                ->first();
            return $client;
        });

        return $collection->map(function ($item, $key) {
            $item->key = $key;
            return $item;
        });

    }

    public function headings(): array
    {
        return [
            'Region',
            'Province',
            'City/Municipality',
            'Barangay',
            'District',
            'LastName',
            'FirstName',
            'MiddleName',
            'ExtraName',
            'Sex',
            'CivilStatus',
            'DOB',
            'ImportFileName',
            'Date',
            "Old Full Name"
        ];
    }


    public function map($grievance_client): array
    {
        //dd( $grievance_client->dirty_list->file_name);
      
        return [
            $grievance_client->psgc ? $grievance_client->psgc->region_name."/".$grievance_client->psgc->region_psgc : "",
            $grievance_client->psgc ? $grievance_client->psgc->province_name."/".$grievance_client->psgc->province_psgc : "",
            $grievance_client->psgc ? $grievance_client->psgc->city_name."/".$grievance_client->psgc->city_name_psgc : "",
            $grievance_client->psgc ? $grievance_client->psgc->brgy_name."/".$grievance_client->psgc->brgy_psgc : "",
            $grievance_client->psgc ? $grievance_client->psgc->subdistrict : "",
           
            $grievance_client->last_name,
            $grievance_client->first_name,
            $grievance_client->middle_name,
            $grievance_client->ext_name,
            $grievance_client->gender == "Lalake" ? "Male" : "Female",
            $grievance_client->civil_status,
            $grievance_client->birth_date ? Carbon::parse($grievance_client->birth_date)->format("m/d/Y") : "",
            $grievance_client->dirty_list->file_name,
            $grievance_client->updated_at,
          //  $grievance_client->activity->properties["old"]["full_name"] ? $grievance_client->activity->properties["old"]["full_name"] : "Not Updated" ,
            
        ];
    }

}
