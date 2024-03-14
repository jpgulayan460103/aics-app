<?php

namespace Database\Seeders;

use App\Models\AicsType;
use App\Models\AicsTypeSubcategory;
use App\Models\Payroll;
use Illuminate\Database\Seeder;

class PayrollAicsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $aics_type =  AicsType::where("name","=","Food Assistance")->firstOrFail();
        $aics_subtype =  AicsTypeSubcategory::where("aics_type_id","=",$aics_type->id)->firstOrFail();

        $payrolls = Payroll::all();
        foreach ($payrolls as $payroll) {
           if(!$payroll->aics_type_id)
           {
                $payroll->aics_type_id = $aics_type->id;
                $payroll->aics_type_subcategory_id  = $aics_subtype->id;
                $payroll->save();
                echo "updated payroll:". $payroll->id . " set assistance type " . $aics_type->name."\n";
           }
        }

    }
}
