<?php

require_once '/includes/utility_functions.php';
require_once '/includes/summoner_api.php';

require_once '/includes/header.php';

// Name of the summoner we are looking up.
$summoner_name = get_request_data('summoner_name');

// Region of the summoner we are looking up.
$region = get_request_data('region_menu');

// If we want to clear our list of people we are following, clear the cookie with that data.
if (get_request_data('clear_following') == 'Yes') {
  clear_cookie('follower_list');
}

// Get the list of people we are following.
$following_list = (array_key_exists('follower_list', $_COOKIE) ? unserialize($_COOKIE['follower_list']) : '');

// If we have a summoner name to add, let's try and add it to the list.
if (!empty($summoner_name)) {
  $curl_helper = new Summoner_API($region);

  // Check if the summoner exists in this region.
  $result = json_decode($curl_helper->get_summoner_by_name($summoner_name), true);

  // Add the summoner to the list if the name was found.
  if (!empty($result)) {
    echo $summoner_name . ' was found. Adding to the list.';

    // Save the Summoner's ID so we can use it for future API calls.
    $summoner_id = $result[strtolower($summoner_name)]['id'];

    // List is in the form of array(region1 => array(summonerID1 => summoner1, summonerID2 => summoner2, ...), ...)
    $following_list[$region][$summoner_id] = $summoner_name;

    // Serialize the array and store it in a cookie.
    setcookie('follower_list', serialize($following_list));
  } else {
    echo $summoner_name . ' was not found. Please try again.';
  }

  echo '<br>';
}

// Display a list of the summoners we are following.
if (empty($following_list)) {
  echo 'You are not following anyone!';
  echo '<br><br>';
} else {
  echo 'Here is the list of the current people you are following:';
  echo '<br>';

  // Create a table with the list of summoners.
  $table_html = '<table>';

  // Header row.
  $table_html .= '<tr>';
  $table_html .= '<td>Region</td>';
  $table_html .= '<td>Summoner Name</td>';
  $table_html .= '<td>Summoner ID</td>';
  $table_html .= '</tr>';

  // Print out the list of summoners.
  foreach ($following_list as $region => $summoner_list) {
    foreach ($summoner_list as $id => $summoner) {
      $table_html .= '<tr>';
      $table_html .= '<td>' . $region . '</td>';
      $table_html .= '<td>' . $summoner . '</td>';
      $table_html .= '<td>' . $id . '</td>';
      $table_html .= '</tr>';
    }
  }
  $table_html .= '</table>';

  echo $table_html;
  echo '<br>';
}

// Form for adding a new summoner to the list.
echo '<form method="POST">';
echo 'Add a summoner name to follow: <input type="text" name="summoner_name">';
echo '<br>';
echo 'Region: ' . build_menu(get_regions_list(), 'region_menu', $region, 'na');
echo '<input type="submit" name="form_submit">';
echo '</form>';

echo '<br><br>';

// Form for clearing the list of summoners.
echo '<form method="POST">';
echo 'Stop following all summoners?';
echo '<input type="submit" value="Yes" name="clear_following">';
echo '</form>';

require_once '/includes/footer.php';
