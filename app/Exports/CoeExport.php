<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CoeExport implements FromView
{

    private $data;
    public function  __construct($data)
    {
        $this->data = $data;
    }


    public function view(): View
    {
        return view('pdf.coe', $this->data);
    }
}
