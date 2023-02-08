<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $categories = array("FHONA","WEDC","YOUTH","PWD","SC","PLHIV");
       
        foreach($categories as $category)
        {
            DB::table('categories')->insert(["category"=>$category ]);
        }
     
    }
}
