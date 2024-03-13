<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesV2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array("FHONA","WEDC","YNSP","PWD","SC","PLHIV","CNSP");
       
        foreach($categories as $category)
        {  
            if( $category == "YNSP")
            {
              $youth =   Category::where("category","=","YOUTH")->first();
              $youth->category = "YNSP";
              $youth->save();
              
            }else
            {
                $res =  Category::firstOrCreate(["category"=>$category]);
            }

           
           
        }
     
    }
}
