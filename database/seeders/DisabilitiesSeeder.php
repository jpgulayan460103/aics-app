<?php

namespace Database\Seeders;

use App\Models\Disabilites;
use Illuminate\Database\Seeder;

class DisabilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subs = [
            "Speech Impairment",
            "Learning Disability",
            "Psychosocial Disability",
            "Deaf/Hard-of-Hearing",
            "Cancer", "Mental Disability",
            "Visual Disability",
            "Intellectual Disability",
            "Physical Disability",
            "Rare Disease"
        ];

        foreach ($subs as $key => $sub) {
            Disabilites::firstOrCreate([
                'disability' => $sub
            ]);
        }
    }
}
