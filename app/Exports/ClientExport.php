<?php

namespace App\Exports;

use App\Models\AicsClient;
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

    // public function query()
    // {
    //     return AicsClient::query()->with(['psgc', 'payroll', 'aics_type'])->whereNotNull('payroll_id');
    // }

    public function collection()
    {
        $collection = AicsClient::query()->with([
            'psgc',
            'payroll',
            'aics_type',
            'subcategory',
            'category',
        ])->whereNotNull('payroll_id')->get();
        return $collection->map(function ($item, $key) {
            $item->key = $key;
            return $item;
        });
    }

    public function headings(): array
    {
        return [
            'Entered',
            'Entered By',
            'Client No',
            'Date Accomplished',
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
            'Age',
            'ModeOfAdmission',
            'Type of Assistance1',
            'Amount1',
            'Source of Fund1',
            'Type of Assistance2',
            'Amount2',
            'Source of Fund2',
            'Type of Assistance3',
            'Amount3',
            'Source of Fund3',
            'Type of Assistance4',
            'Amount4',
            'Source of Fund4',
            'ClientCategory',
            'All Region',
            'SexValue',
            'Column1',
            'ProvValue',
            'MunCityValue',
            'SFvalue',
            'CHARGING',
            'MODE OF ASSISTANCE2',
            'SERVICE PROVIDER',
            'B. LAST NAME',
            'B. FIRST NAME3',
            'B. MIDDLE NAME',
            '4PS',
            'Column2',
            'Column3',
            'Column4',
            'Column5',
            'Column6',
            'Column7',
            'Column8',
            'Column9',
            'Column10',
        ];
    }

    public function map($aics_client): array
    {
        return [
            $aics_client->created_at->format("m/d/Y h:i:s"),
            env('COMPUTERNAME'),
            $aics_client->key + 1,
            $aics_client->updated_at->format("m/d/Y h:i:s"),
            $aics_client->psgc?->region_name."/".$aics_client->psgc?->region_psgc,
            $aics_client->psgc?->province_name."/".$aics_client->psgc?->province_psgc,
            $aics_client->psgc?->city_name."/".$aics_client->psgc?->city_psgc,
            $aics_client->psgc?->brgy_name."/".$aics_client->psgc?->brgy_psgc,
            $aics_client->psgc?->district,
            $aics_client->last_name,
            $aics_client->first_name,
            $aics_client->middle_name,
            $aics_client->ext_name,
            $aics_client->gender == "Lalake" ? "Male" : "Female",
            "civil_status",
            Carbon::parse($aics_client->birth_date)->format("m/d/Y"),
            $aics_client->age,
            "Referral",
            $aics_client->aics_type?->name,
            $aics_client->payroll?->amount,
            "Source of Fund1",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            $aics_client->category ? $aics_client->category->category : "",
            "All",
            "1",
            "1",
            "1",
            "1",
            "1",
            "charging",
            "CAV",
            "",
            $aics_client->last_name,
            $aics_client->first_name,
            $aics_client->middle_name,
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
        ];
    }
    
}
