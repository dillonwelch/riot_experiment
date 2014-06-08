<?php

require_once '/includes/curl.php';


echo "Hey there!<br>";

$curl_helper = new CURLHelper();

$result = $curl_helper->make_api_call();

echo '<br><br><br><br>';

echo count($result);

echo '<br><br>';

echo var_dump($result);

echo '<br><br>';

echo "<br>That was fun.<br>";

echo '"This product is not endorsed, certified or otherwise approved in any way by Riot Games, Inc. or any of its affiliates."';
