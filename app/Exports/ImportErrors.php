<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ImportErrors implements FromCollection
{

    private $errors;
    public function  __construct($errors)
    {
        $this->errors = $errors;
    }

    public function collection()
    {
        return new Collection($this->errors);
    }
}