<?php

namespace App\Exports;

use App\Models\AicsClient;
use App\Models\Payroll;
use App\Models\PayrollClient;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable, RemembersRowNumber;

    public function collection()
    {
        $collection = AicsClient::query()->with([
            'psgc',
            'aics_type',
            'subcategory',
            'category',
            'user',
            'payroll_client.payroll',
            'dirty_list',
        ]);

        $collection = $collection->get();

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
            'Payroll',
            'Sequence',
            'Claim Status',
            'ImportFileName',
            'Mobile',
            'Validation Status'
        ];
    }

    public function map($payroll_client): array
    {
        //dd( $payroll_client->dirty_list->file_name);
      
        return [
            $payroll_client->psgc ? $payroll_client->psgc->region_name."/".$payroll_client->psgc->region_psgc : "",
            $payroll_client->psgc ? $payroll_client->psgc->province_name."/".$payroll_client->psgc->province_psgc : "",
            $payroll_client->psgc ? $payroll_client->psgc->city_name."/".$payroll_client->psgc->city_name_psgc : "",
            $payroll_client->psgc ? $payroll_client->psgc->brgy_name."/".$payroll_client->psgc->brgy_psgc : "",
            $payroll_client->psgc ? $payroll_client->psgc->subdistrict : "",
           
            $payroll_client->last_name,
            $payroll_client->first_name,
            $payroll_client->middle_name,
            $payroll_client->ext_name,
            $payroll_client->gender == "Lalake" ? "Male" : "Female",
            $payroll_client->civil_status,
            $payroll_client->birth_date ? Carbon::parse($payroll_client->birth_date)->format("m/d/Y") : "",
            $payroll_client->payroll_client && $payroll_client->payroll_client->payroll ? $payroll_client->payroll_client->payroll->title : "No Payroll",
            $payroll_client->payroll_client ? $payroll_client->payroll_client->sequence : "No Payroll",
            $payroll_client->payroll_client ? $payroll_client->payroll_client->status : "No Payroll",
            $payroll_client->dirty_list->file_name,
            $payroll_client->mobile_number,           
            $payroll_client->is_verified,           
            //$payroll_client->payroll_client ? $payroll_client->dirty_list->file_name : "",

            
        ];
    }
    
}
