<?php

namespace Database\Seeders;

use App\Models\AicsClient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AicsClientMetaphoneUuidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aics_clients = AicsClient::all();
        foreach ($aics_clients as $key => $aics_client) {
            $aics_client->uuid = Str::uuid();
            $aics_client->meta_full_name = metaphone($aics_client->first_name).metaphone($aics_client->middle_name).metaphone($aics_client->last_name);
            $aics_client->save();
            echo "client:".($key+1)." updated uuid: ".$aics_client->uuid."\n";
        }
    }
}
