<?php

namespace Database\Seeders;

use App\Models\AicsType;
use App\Models\AicsTypeSubcategory;
use Illuminate\Database\Seeder;

class AicsTypeV2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = array(
            array(
                "Type" => "Medical Assistance",
                "Subtype" => array("Laboratory", "Medicine")
            ),
            array(
                "Type" => "Funeral Assistance",
                "Subtype" => array("Burial", "Transfer of Cadaver")
            ),
            array(
                "Type" => "Food Assistance",
                "Subtype" => array("Daily Consumption and Other Needs", "Food and Other Nutritional Requirements for Sustenance.")
            ),
            array(
                "Type" => "Transportation Assistance",
                "Subtype" => array("Locally stranded individuals (LSI)", "Repatriates")
            ),
            array(
                "Type" => "Educational Assistance",
                "Subtype" => array("Tuition Fee", "Other School Needs")
            ),
            array(
                "Type" =>  "Other Cash Assistance",
                "Subtype" => array("Fire Victim", "Victim of Calamity", "Flood Victim")
            ),
            /*array(
                "Type" =>  "Emergency Cash Transfer",
                "Subtype" => array("Fire Victim", "Victim of Calamity", "Flood Victim")
            ),*/
        );

        $ids = array();

        foreach ($types as $data) {
            $type = AicsType::where("name", $data['Type'])->first();
            if ($type) {
                foreach ($data['Subtype'] as $subtypeName) {
                    if (isset($data['Subtype'])) {
                        
                        AicsTypeSubcategory::firstOrCreate([
                            'aics_type_id' => $type->id,
                            'name' => $subtypeName
                        ]);
                    }
                }
                $ids[] =  $type->id;
            } else {
                $type = AicsType::create(['name' => $data['Type']]);
                if (isset($data['Subtype'])) {
                    foreach ($data['Subtype'] as $subtypeName) {
                        AicsTypeSubcategory::create([
                            'aics_type_id' => $type->id,
                            'name' => $subtypeName
                        ]);
                    }
                }
                $ids[] =  $type->id;
            }
        }

        AicsType::whereNotIn('id', $ids)->delete();
    }
}
