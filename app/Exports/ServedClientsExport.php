<?php

namespace App\Exports;

use App\Models\ServedClient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServedClientsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ServedClient::all();
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
            # 'Type of Assistance3',
            # 'Amount3',
            # 'Source of Fund3',
            # 'Type of Assistance4',
            # 'Amount4',
            # 'Source of Fund4',
            'ClientCategory',
            # 'All Region',
            # 'SexValue',
            # 'Column1',
            # 'ProvValue',
            # 'MunCityValue',
            # 'SFvalue',
            'CHARGING',
            'MODE OF ASSISTANCE2',
            'SERVICE PROVIDER',
            'B. LAST NAME',
            'B. FIRST NAME3',
            'B. MIDDLE NAME',
            'B. EXT',
            'Sub Category',
            'Pantawid Beneficiary',
            'Occupation',
            'Assessment',
            #'Column4',
            #'Column5',
            #'Column6',
            #'Column7',
            #'Column8',
            #'Column9',
            #'Column10',
            'Mobile',
            'QR-ID'
        ];
    }

    public function map($payroll_client): array
    {
        //dd($payroll_client);

        return [
            $payroll_client->created_at->format("m/d/Y h:i:s"),
            $this->claim_status == "claimed" ? ($payroll_client->aics_client->user ?  $payroll_client->aics_client->user->name : env('COMPUTERNAME')) : "UNCLAIMED",
            $payroll_client->sequence,
            $payroll_client->updated_at->format("m/d/Y h:i:s"),
            $payroll_client->aics_client->psgc ? $payroll_client->aics_client->psgc->region_name . "/" . $payroll_client->aics_client->psgc->region_psgc : "",
            $payroll_client->aics_client->psgc ? $payroll_client->aics_client->psgc->province_name . "/" . $payroll_client->aics_client->psgc->province_psgc : "",
            $payroll_client->aics_client->psgc ? $payroll_client->aics_client->psgc->city_name . "/" . $payroll_client->aics_client->psgc->city_name_psgc : "",
            $payroll_client->aics_client->psgc ? $payroll_client->aics_client->psgc->brgy_name . "/" . $payroll_client->aics_client->psgc->brgy_psgc : "",
            $payroll_client->aics_client->psgc ? $payroll_client->aics_client->psgc->subdistrict : "",

            $payroll_client->aics_client->last_name,
            $payroll_client->aics_client->first_name,
            $payroll_client->aics_client->middle_name,
            $payroll_client->aics_client->ext_name,
            $payroll_client->aics_client->gender == "Lalake" ? "Male" : "Female",
            $payroll_client->aics_client->civil_status,
            Carbon::parse($payroll_client->aics_client->birth_date)->format("m/d/Y"),
            $payroll_client->aics_client->age,
            $payroll_client->aics_client->mode_of_admission,
            $payroll_client->aics_client->aics_type ? $payroll_client->aics_client->aics_type->name : "",
            $payroll_client->payroll ?  $payroll_client->payroll->amount : "",
            $payroll_client->payroll ?  $payroll_client->payroll->source_of_fund : "",
            "",
            "",
            #"",
            #"",
            #"",
            #"",
            #"",
            #"",
            "",
            $payroll_client->aics_client->category ? $payroll_client->aics_client->category->category : "",
            # "All",
            # "1",
            # "1",
            # "1",
            # "1",
            #"1",
            $payroll_client->payroll ? $payroll_client->payroll->charging : "",
            "CAV",
            "",
            $payroll_client->aics_client->last_name,
            $payroll_client->aics_client->first_name,
            $payroll_client->aics_client->middle_name,
            $payroll_client->aics_client->ext_name,
            $payroll_client->aics_client->subcategory ? $payroll_client->aics_client->subcategory->subcategory : "",
            strpos($payroll_client->aics_client->subcategory, '4ps') !== false ? 'yes' : 'no',
            $payroll_client->aics_client->occupation,
            $payroll_client->aics_client->assessment,
            #"",
            #"",
            #"",
            #"",
            #"",
            $payroll_client->mobile_number,
            $payroll_client->payroll ?   $payroll_client->payroll->id . "-" .  $payroll_client->id  : "",
        ];
    }
    


}
