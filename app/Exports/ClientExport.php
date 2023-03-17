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

    private $payroll;
    private $claim_status;
    public function  __construct(Payroll $payroll, $claim_status = "claimed")
    {
        $this->payroll = $payroll;
        $this->claim_status = $claim_status;
    }

    public function collection()
    {

        $collection = PayrollClient::query()->with([
            'aics_client',
            'aics_client.psgc',
            'aics_client.aics_type',
            'aics_client.subcategory',
            'aics_client.category',
            'aics_client.user'
        ]);
        $collection->where('payroll_id', $this->payroll->id);
        if($this->claim_status == "unclaimed"){
            $collection->whereNull('status');
        }else{
            $collection->where('status', 'claimed');
        }
        $collection->orderBy('sequence',"asc");
        $collection = $collection->get();

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

    public function map($payroll_client): array
    {
        //dd($payroll_client);
      
        return [
            $payroll_client->created_at->format("m/d/Y h:i:s"),
            $this->claim_status == "claimed" ? ( $payroll_client->aics_client->user?  $payroll_client->aics_client->user->name :env('COMPUTERNAME')) : "UNCLAIMED",
            $payroll_client->sequence,
            $payroll_client->updated_at->format("m/d/Y h:i:s"),
            $payroll_client->aics_client->psgc ? $payroll_client->aics_client->psgc->region_name."/".$payroll_client->aics_client->psgc->region_psgc : "",
            $payroll_client->aics_client->psgc ? $payroll_client->aics_client->psgc->province_name."/".$payroll_client->aics_client->psgc->province_psgc : "",
            $payroll_client->aics_client->psgc ? $payroll_client->aics_client->psgc->city_name."/".$payroll_client->aics_client->psgc->city_name_psgc : "",
            $payroll_client->aics_client->psgc ? $payroll_client->aics_client->psgc->brgy_name."/".$payroll_client->aics_client->psgc->brgy_psgc : "",
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
            $payroll_client->payroll ?  $payroll_client->payroll->amount: "",
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
            $payroll_client->aics_client->category ? $payroll_client->aics_client->category->category : "",
            "All",
            "1",
            "1",
            "1",
            "1",
            "1",
            $payroll_client->payroll ? $payroll_client->payroll->charging : "",
            "CAV",
            "",
            $payroll_client->aics_client->last_name,
            $payroll_client->aics_client->first_name,
            $payroll_client->aics_client->middle_name,
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
