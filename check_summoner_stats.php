<?php

require_once '/includes/utility_functions.php';
require_once '/includes/game_api.php';

require_once '/includes/header.php';

// Get the list of people we are following.
$following_list = get_cookie('follower_list', true);

echo '<b>Recent game stats of the people you are following.</b>';

echo '<br><br>';

if (empty($following_list)) {
  echo 'You are not following anyone!';
  echo '<br><br>';
  require_once '/includes/footer.php';
  die();
} else {
  $game_api = new Game_API();

  echo '<b>Stats from last played game:</b>';

  echo '<br><br>';

  // Display a table of some recent game stats for each player we are following.
  $table_html = '<table>';
  $table_html .= '<tr>';
  $table_html .= '<td>Region</td>';
  $table_html .= '<td>Summoner Name</td>';
  $table_html .= '<td>Won last game</td>';
  $table_html .= '<td>Champions killed</td>';
  $table_html .= '<td>Champion level</td>';
  $table_html .= '<td>Damage dealt to champions</td>';
  $table_html .= '</tr>';

  // $following_list has an array of summonerID => summonerName pairs for each region.
  foreach ($following_list as $region => $summoner_list) {
    $summoner_id_list = array_keys($summoner_list);
    foreach ($summoner_id_list as $summoner_id) {
      // Grab the data from the API.
      //$result = json_decode($game_api->get_recent_game_data($summoner_id, $region), true);
      $result = $game_api->get_recent_game_data($summoner_id, $region);

      if ($game_api->b_successful_call) {
        // We only care about the most recent game.
        $recent_game = $result['games'][0];
        $recent_game_stats = $recent_game['stats'];

        // Build the table row.
        $table_html .= '<tr>';
        $table_html .= '<td>' . htmlentities($region) . '</td>';
        $table_html .= '<td>' . htmlentities($following_list[$region][$summoner_id]) . '</td>';
        $table_html .= '<td>';
        if ($recent_game_stats['win']) {
          $table_html .= 'Yes';
        } else {
          $table_html .= 'No';
        }
        $table_html .= '</td>';
        $table_html .= '<td>' . htmlentities($recent_game_stats['championsKilled']) . '</td>';
        $table_html .= '<td>' . htmlentities($recent_game_stats['level']) . '</td>';
        $table_html .= '<td>' . htmlentities($recent_game_stats['totalDamageDealtToChampions']) . '</td>';
        $table_html .= '</tr>';
      } else {
        $table_html .= '<tr><td>There was an error making the request.</td></tr>';
      }
    }
  }

  // Close out the table and display it.
  $table_html .= '</table>';
  echo $table_html;
  echo '<br><br>';
}

require_once '/includes/footer.php';
