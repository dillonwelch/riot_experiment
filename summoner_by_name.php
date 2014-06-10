<?php

require_once '/includes/utility_functions.php';
require_once '/includes/summoner_api.php';

require_once '/includes/header.php';

?>
<b> The best Hello World page </b>
<br><br>
<?php

// Name of the summoner we are looking up.
$summoner_name = get_request_data('summoner_name');

// Region of the summoner we are looking up.
$region = get_request_data('region_menu');

$form_html = '<form method="POST">';
$form_html .='Summoner Name: <input type="text" name="summoner_name" value="' . (!empty($summoner_name) ? htmlentities($summoner_name) : 'Bumblingbear') . '">';
$form_html .='Region: ' . build_menu(get_regions_list(), 'region_menu', $region, 'na');
$form_html .='<input type="submit" name="form_submit">';
$form_html .='</form>';

echo $form_html;

if (!empty($summoner_name)) {
  $summoner_api = new Summoner_API($region);

  $result = $summoner_api->get_summoner_by_name($summoner_name, $region);

  if (!empty($result)) {
    if ($summoner_api->b_successful_call) {
      $table_html = '<table>';
      foreach ($result as $summoner) {
        foreach ($summoner as $key => $value) {
          $table_html .= '<tr>';
          $table_html .= '<td>' . $key . '<td>';
          $table_html .= '<td>' . $value . '<tr>';
          $table_html .= '</tr>';
        }
      }
      $table_html .= '</table>';

      echo $table_html;
    } else {
      echo 'There was an error making the request. Message: ' . htmlentities($result['status']['message']) . '. Status Code: ' . htmlentities($result['status']['status_code']) . '.';
    }

  } else {
    echo 'No results :(';
  }

  echo '<br><br>';

}

require_once '/includes/footer.php';
