<?php

require_once '/includes/utility_functions.php';

require_once '/includes/header.php';

// Get the list of people we are following.
$following_list = (array_key_exists('follower_list', $_COOKIE) ? unserialize($_COOKIE['follower_list']) : '');

if (empty($following_list)) {
  echo 'You are not following anyone!';
  echo '<br><br>';
} else {
  echo 'You are following people!';
  echo '<br><br>';

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

require_once '/includes/footer.php';
