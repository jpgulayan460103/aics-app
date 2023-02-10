<?php

namespace App\Imports;

use App\Models\AicsClient;
use App\Models\DirtyListClients;
use App\Models\Psgc;
use App\Rules\AllowedStringName;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientsImport implements WithHeadingRow, ToModel, WithStartRow, WithBatchInserts, WithChunkReading, WithValidation
{
    /**
     * @param Collection $collection
     */

     use RemembersRowNumber;
     private $dirty_list_id;

     public function  __construct()
     {

     }

    public function model(array $row)
    {
        $birth_date = null;
        if(isset($row['birth_date'])){
            switch (gettype($row['birth_date'])) {
                case 'integer':
                    $birth_date = gmdate("Y-m-d", ($row['birth_date'] - 25569) * 86400);
                    break;
                case 'string':
                    $birth_date = trim(date_format(date_create($row['birth_date']), "Y-m-d"));
                    break;
                default:
                    $birth_date = null;
                    break;
            }
        }
        return new AicsClient([
            'first_name'    => mb_strtoupper(trim($row['first_name'])),
            'middle_name'   => mb_strtoupper(trim($row['middle_name'])),
            'last_name'     => mb_strtoupper(trim($row['last_name'])),
            'ext_name'      => mb_strtoupper(trim($row['ext_name'])),
            'birth_date'    => $birth_date,
            'psgc_id'       => Psgc::where('brgy_psgc', $row['psgc'])->first()->id,
        ]);

        
    }

 
    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required','max:255', new AllowedStringName()],
            'middle_name' => ['max:255', new AllowedStringName()],
            'last_name' => ['required','max:255', new AllowedStringName()],
            'ext_name' => ['max:255', new AllowedStringName()],
            'birth_date' => 'required|date',
            'barangay' => 'required',
            'city_muni' => 'required',
            'province' => 'required',
            'region' => 'required',
            'psgc' => 'required|exists:psgcs,brgy_psgc',
            // 'fund_source' => 'required',
        ];
    }

    public function prepareForValidation($data, $index)
    {
        if(isset($data['birth_date'])){
            switch (gettype($data['birth_date'])) {
                case 'integer':
                    $data['birth_date'] = gmdate("Y-m-d", ($data['birth_date'] - 25569) * 86400);
                    break;
                case 'string':
                    // $data['4'] = trim(date_format(date_create($data['birth_date']), "Y-m-d"));
                    break;
                default:
                    $data['birth_date'] = null;
                    break;
            }
        }
        
        return $data;
    }
    
}
