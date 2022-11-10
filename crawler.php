<?php
# goutte_xpath.php

require 'vendor/autoload.php';
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

$client = new Client(HttpClient::create(['verify_peer' => false, 'verify_host' => false]));
#$client->request('GET', 'https://example.com');

#$client = new \Goutte\Client();

$crawler = $client->request('GET', 'http://www.officialgazette.gov.ph/nationwide-holidays/2023/');

/*$links = $crawler->evaluate('//div[@id="nationwide-regular-holidays"][1]//h3/a');
echo "<pre>";
print_r($links);
echo  "</pre>";

foreach ($links as $link) {
    echo $link->textContent.PHP_EOL;
}*/

$crawler->filter('div#nationwide-regular-holidays table tr.holiday-group')->each(function ($node) {
    echo $node->text().PHP_EOL ."<br/>"; 
   
});

?>