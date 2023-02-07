<?php

namespace App\Imports;

use App\Models\DirtyListClients;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;




class ClientsImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading
{
    /**
     * @param Collection $collection
     */

     use RemembersRowNumber;

     public function  __construct($dirty_list_id)
     {
         $this->dirty_list_id= $dirty_list_id;
     }

    public function model(array $row)
    {
        $currentRowNumber = $this->getRowNumber();
       
        return new DirtyListClients([
            'dirty_list_id' => $this->dirty_list_id,
            'first_name'    => trim($row[0]),
            'middle_name'   => trim($row[1]),
            'last_name'     => trim($row[2]),
            'ext_name'      => trim($row[3]),
            'birth_date'    => trim(date_format(date_create($row[4]), "Y-m-d")),
            'barangay'      => strtoupper(trim($row[5])),
            'city_muni'     => strtoupper(trim($row[6])),
            'province'      => strtoupper(trim($row[7])),
            'region'        => strtoupper(trim($row[8])),
            'fund_source'   => trim($row[9]),            
        ]);

        
    }

    /* public function headingRow(): int
    {
        return 1;
    }*/

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
