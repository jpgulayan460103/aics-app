<?php

namespace Database\Seeders;

use App\Models\AicsClient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AicsClientVerifiedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aics_clients = AicsClient::withTrashed()->with("payroll_client")->get();
        foreach ($aics_clients as $key => $aics_client) {
            
            if($aics_client->payroll_client)
            {
                $aics_client->is_verified="verified";
            }

            $aics_client->save();
            echo "client:".($key+1)." updated: ".$aics_client->full_name." status: " .$aics_client->is_verified."\n";
        }
    }
}
