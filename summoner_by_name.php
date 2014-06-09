<?php

require_once '/includes/utility_functions.php';
require_once '/includes/summoner_api.php';

require_once '/includes/header.php';

?>
<b> The best Hello World page </b>
<br><br>
<?php

$summoner_name = get_request_data('summoner_name');
$region = get_request_data('region_menu');

$regions = get_regions_list();

// TODO why doesn't it work when I directly have the HTML for this???
echo '
<html>
<body>
<form method="POST">
Summoner Name: <input type="text" name="summoner_name" value="Bumblingbear">
Region: ' . build_menu($regions, 'region_menu', $region, 'na') . '
<input type="submit" name="form_submit">
</form>
';


if (!empty($summoner_name)) {

$curl_helper = new Summoner_API($region);

//TODO what if call goes bad?
$result = json_decode($curl_helper->get_summoner_by_name($summoner_name), true);

if (!empty($result)) {

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

} else {
  echo 'No results :(';
}

echo '<br><br>';

}

require_once '/includes/footer.php';
