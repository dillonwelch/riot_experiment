<?php

require_once '/includes/curl.php';
require_once '/includes/utility_functions.php';

$summoner_name = get_request_data('summoner_name');

// TODO why doesn't it work when I directly have the HTML for this???
echo '
<html>
<body>
<form method="POST">
Summoner Name: <input type="text" name="summoner_name">
<input type="submit" name="form_submit">
</form>
';


if (!empty($summoner_name)) {

$curl_helper = new CURLHelper($summoner_name);

//TODO what if call goes bad?
$result = json_decode($curl_helper->make_api_call(), true);

echo '<table>';

foreach ($result as $summoner) {
  foreach ($summoner as $key => $value) {
    echo '<tr>';
    echo '<td>' . $key . '<td>';
    echo '<td>' . $value . '<tr>';
    echo '</tr>';
  }
}

echo '</table>';

echo '<br><br>';

echo '"This product is not endorsed, certified or otherwise approved in any way by Riot Games, Inc. or any of its affiliates."';

}

?>

</body>
</html>
