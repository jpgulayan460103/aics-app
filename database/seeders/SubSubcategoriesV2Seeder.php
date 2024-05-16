<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubSubcategoriesV2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* $s = New Subcategory;
       $s->subcategory = "KIA/WIA";
       $s->save();

       $s = New Subcategory;
       $s->subcategory = "None of the above";
       $s->save();*/

        $subs = ["KIA/WIA", "None of the above", "Minimum Wage Earner"];

        foreach ($subs as $key => $sub) {
            Subcategory::firstOrCreate([
                'subcategory' => $sub
            ]);
        }
    }
}
