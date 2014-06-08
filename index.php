<?php

require_once '/includes/curl.php';

$curl_helper = new CURLHelper();

//TODO what if call goes bad?
$result = json_decode($curl_helper->make_api_call(), true);

echo '<table>';

foreach ($result['bumblingbear'] as $key => $value) {
  echo '<tr>';
  echo '<td>' . $key . '<td>';
  echo '<td>' . $value . '<tr>';
  echo '</tr>';
}

echo '</table>';

echo '<br><br>';

echo '"This product is not endorsed, certified or otherwise approved in any way by Riot Games, Inc. or any of its affiliates."';
