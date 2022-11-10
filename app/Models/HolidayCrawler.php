<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class HolidayCrawler extends Model
{
    use HasFactory;

    public function crawler()
    {
        $client = new Client(HttpClient::create(['verify_peer' => false, 'verify_host' => false]));
        $crawler = $client->request('GET', 'http://www.officialgazette.gov.ph/nationwide-holidays/2023/');
        $crawler->filter('div#nationwide-regular-holidays table tr.holiday-group')->each(function ($node) {
            echo $node->text().PHP_EOL ."<br/>"; 
           
        });
    }
}
