<?php

namespace App\Imports;

use App\Models\Psgc;
use App\Models\ServedClient;
use App\Models\ServedClientsMeta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Rules\AllowedStringName;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Illuminate\Support\Str;

class ServedClientsImport  implements WithHeadingRow, WithStartRow, WithBatchInserts, WithChunkReading, WithValidation, OnEachRow
#ToModel,
{
    protected $knownColumns = [
        'entered',
        'entered_by',
        'client_no',
        'date_accomplished',
        'firstname',
        'middlename',
        'lastname',
        'extraname',
        'barangay',
        'citymunicipality',
        'province',
        'sex',
        'civil_status',
        'dob',
        'age',
        'modeofadmission',
        'type_of_assistance1',
        'amount1',
        'source_of_fund1',
        'clientcategory',
        'charging',
        'mode_of_assistance2',
    ];

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function onRow(Row $row)
    {

        DB::enableQueryLog();
        $first_name = mb_strtoupper(trim($row['firstname'] ?? null));
        $middle_name = mb_strtoupper(trim($row['middlename'] ?? null));
        $last_name = mb_strtoupper(trim($row['lastname'] ?? null));
        $ext_name = mb_strtoupper(trim($row['extraname'] ?? null));

        list($barangayName, $barangayNumber) = explode('/', $row["barangay"]);
        list($citymunicipalityName, $citymunicipalityNumber) = explode('/', $row["citymunicipality"]);
        list($provinceName, $provinceNumber) = explode('/', $row["province"]);

        $psgc = Psgc::where('brgy_psgc', $barangayNumber)
            ->where('city_name_psgc', $citymunicipalityNumber)
            ->where('province_psgc', $provinceNumber)
            ->first();


        $served_client =  ServedClient::create(
            [
                'entered_datetime' => $row["entered"],
                'entered_by' => $row["entered_by"],
                'client_number' => $row["client_no"],
                'accomplished_datetime' => $row["date_accomplished"],
                'psgc_id' => $psgc->id,
                'psgc' => $barangayNumber,
                'last_name' => $last_name,
                'first_name' => $first_name,
                'middle_name' =>  $middle_name,
                'ext_name' =>   $ext_name,
                'meta_last_name' => metaphone($last_name),
                'meta_first_name' => metaphone($first_name),
                'meta_middle_name' => metaphone($middle_name),
                'meta_full_name' => metaphone($first_name) . metaphone($middle_name) .  metaphone($last_name),


                'sex' => $row["sex"],
                'civil_status' => $row["civilstatus"],
                'birth_date' => $row["dob"],
                'age' => $row["age"],
                'mode_of_admission' => $row["modeofadmission"],
                'type_of_assistance' => $row["type_of_assistance1"],
                'amount' => $row["amount1"],
                'source_of_fund' => $row["source_of_fund1"],
                'client_category' => $row["clientcategory"],
                'charging' => $row["charging"],
                'mode_of_assistance' => $row["mode_of_assistance2"],
                'date_claimed' => $row["date_accomplished"],
                'uuid' => Str::uuid(),

            ]
        );

        Log::info("start meta");
        $rowArray = $row->toArray();



        foreach ($rowArray as $key => $value) {
            Log::info("checking for : " .  $key);

            if (!in_array($key, $this->knownColumns) &&  $value != "") {
                Log::info("creating : " .  $key);

                $meta = ServedClientsMeta::create([
                    'served_client_id' => $served_client->id,
                    'key' => $key,
                    'value' => $value,
                ]);

                Log::info("created : " . $meta);
            }
        }

        Log::info("end meta");

        return  $served_client;
    }


    public function rules(): array
    {

        # return [];
        return [
            'firstname' => ['required', 'max:255', new AllowedStringName()],
            'middlename' => ['max:255', new AllowedStringName()],
            'lastname' => ['required', 'max:255', new AllowedStringName()],
            'extraname' => ['max:255', new AllowedStringName()],
            'street_number' => 'max:255',
            'birth_date' => 'sometimes|date',
            'psgc' => 'sometimes|exists:psgcs,brgy_psgc',
            'entered' => ['required'],
            'entered_by' => ['sometimes'],
            'client_no' => ['required'],
            'date_accomplished' => ['required'],
            'sex' => ['required'],
            'civilstatus' => ['required'],
            'modeofadmission' => ['required'],
            'type_of_assistance1' => ['required'],
            'amount1' => ['required'],
            'source_of_fund1' => ['required'],
            'clientcategory' => ['required'],
            'charging' => ['required'],
            'mode_of_assistance2' => ['required'],

        ];
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
}
