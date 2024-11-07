<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class EncoderRoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'encoder',
        ];
        foreach ($roles as $role) {
            $role = Role::create([
                'name' => $role
            ]);
            echo "Inserted Role -> ".$role->name."\n";
        }
    }
}
