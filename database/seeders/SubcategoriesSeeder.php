<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subcategory;

class SubcategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = array(
            "Solo Parent",
            "Indigenous People",
            "Recovering Person who used Drugs",
            "4ps DSWD Beneficiary",
            "Street Dweller",
            "Psychosocial/Mental/Learning Disability",
            "Stateless Persons/Assylum Seekers/Refugies",
            "Others",
        );

        foreach($subcategories as $subcat)
        {
            $s = New Subcategory;
            $s->subcategory = $subcat;
            $s->save();
        }
    }
}
