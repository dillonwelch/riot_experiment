<?php

// The base URL of all API calls.
define('BASE_API_URL', 'https://na.api.pvp.net/api/lol/');

define('API_KEY', '25f78534-b9f9-43de-93c4-a371dad3066c');

echo "Hey there!<br>";

$url = BASE_API_URL . 'na/v1.4/summoner/by-name/BumblingBear?api_key=' . API_KEY;

echo $url . "\n";

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HEADER, 0);
//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //this works!
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($curl, CURLOPT_CAINFO, getcwd() . '/cert/riot_cert.cer');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($curl);

echo '<br><br><br><br>';

echo var_dump(curl_getinfo($curl));

echo '<br><br>';

echo curl_error($curl);

echo '<br><br>';

echo curl_errno($curl);

echo '<br><br>';

echo count($result);

echo '<br><br>';

echo var_dump($result);

echo '<br><br>';


curl_close($curl);

//echo $result;

echo "<br>That was fun.";




echo '"This product is not endorsed, certified or otherwise approved in any way by Riot Games, Inc. or any of its affiliates."';
