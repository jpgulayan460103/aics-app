<?php

namespace App\Imports;

use App\Models\AicsClient;
use App\Models\DirtyList;
use App\Models\DirtyListClients;
use App\Models\Psgc;
use App\Rules\AllowedStringName;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use app\Models\Category;
use App\Models\Subcategory;

class ClientsImport implements WithHeadingRow, ToModel, WithStartRow, WithBatchInserts, WithChunkReading, WithValidation
{
    /**
     * @param Collection $collection
     */

     use RemembersRowNumber;
     private $dirtyList;

     public function  __construct(DirtyList $dirtyList)
     {
        $this->dirtyList = $dirtyList;
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

       $psgc_id = null;
        if(isset($row['psgc'])){
            $psgc = Psgc::where('brgy_psgc', $row['psgc'])->first();
            $psgc_id = $psgc->id;
        }
        $first_name = mb_strtoupper(trim($row['first_name'] ?? null));
        $middle_name = mb_strtoupper(trim($row['middle_name'] ?? null));
        $last_name = mb_strtoupper(trim($row['last_name'] ?? null));
        $ext_name = mb_strtoupper(trim($row['ext_name'] ?? null));
       
        #FHONA,WEDC,YOUTH,PWD,SC,PLHIV
        $category_id = 1;
        if(isset($row["category"]))
        {
            $category = Category::where("category","=",strtoupper(trim($row["category"])))->first();
            if($category)
            {
                $category_id = $category->id;
            }
        }

        $subcategory_id = null;
        if(isset($row["subcategory"]))
        {
            $subcategory = Subcategory::where("subcategory","=",strtoupper(trim($row["category"])))->first();
            if($subcategory)
            {
                $subcategory_id = $subcategory->id;
            }
        }

        return new AicsClient([
            'dirty_list_id' => $this->dirtyList->id,
            'first_name'    => $first_name,
            'middle_name'   => $middle_name,
            'last_name'     => $last_name,
            'ext_name'      => $ext_name,
            'street_number' => mb_strtoupper(trim($row['street_number'] ?? null)),
            'meta_full_name' => metaphone($first_name).metaphone($middle_name).metaphone($last_name),
            'birth_date'    => $birth_date,
            'gender'        => isset($row['gender']) ? $row['gender'] : null,
            'psgc_id'       => $psgc_id,
            'full_name'     => "$first_name $middle_name $last_name $ext_name",
            'mobile_number' => isset($row['mobile_number']) ? $row['mobile_number'] : null,
            'occupation' => isset($row['occupation']) ? $row['occupation'] : null,
            'monthly_salary' => isset($row['monthly_salary']) ? $row['monthly_salary'] : null,
            'civil_status' => isset($row['civil_status']) ? ucwords(strtolower($row['civil_status'])) : null,
            'mode_of_admission' => "Referral",
            'aics_type_id' => "8",
            'category_id' => $category_id,
            'subcategory_id' => $subcategory_id,

            
            
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
            'street_number' => 'max:255',
            'birth_date' => 'sometimes|date',
            'psgc' => 'sometimes|exists:psgcs,brgy_psgc',
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

            try {
                $data['birth_date'] = Carbon::parse($data['birth_date'])->toDateString();
            } catch (\Exception $e) {
                $data['birth_date'] = null;
            }
        }

        if(isset($data['gender'])){
            $data['gender'] = strtoupper($data['gender'][0]) == "M" ? "Lalake" : "Babae";
        }

        if(empty($data['psgc'])){
            unset($data['psgc']);
        }
        
        if(empty($data['birth_date'])){
            unset($data['birth_date']);
        }
        
        return $data;
    }
    
}
