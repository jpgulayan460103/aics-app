<?php

namespace Database\Seeders;

use App\Models\AicsRecords;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class AicsRecordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'user',
            'admin',
        ];
        foreach ($roles as $role) {
            $role = Role::create([
                'name' => $role
            ]);
            echo "Inserted Role -> ".$role->name."\n";
        }
    }

}
