<?php

require_once '/includes/utility_functions.php';
require_once '/includes/game_api.php';

require_once '/includes/header.php';

// Get the list of people we are following.
$following_list = (array_key_exists('follower_list', $_COOKIE) ? unserialize($_COOKIE['follower_list']) : '');

echo '<b>Recent game stats of the people you are following.</b>';

echo '<br><br>';

if (empty($following_list)) {
  echo 'You are not following anyone!';
  echo '<br><br>';
  require_once '/includes/footer.php';
  die();
} else {
  $summoner_id_list = array();

  foreach ($following_list as $region => $summoner_list) {
    foreach ($summoner_list as $id => $summoner) {
      $summoner_id_list[$region][] = $id;
    }
  }

  var_dump($following_list);
  echo '<br><br>';
  var_dump($summoner_id_list);

  $game_api = new Game_API();

  echo '<b>Stats from last played game:</b>';

  echo '<br><br>';

  $table_html = '<table>';
  $table_html .= '<tr>';
  $table_html .= '<td>Region</td>';
  $table_html .= '<td>Summoner Name</td>';
  $table_html .= '<td>Won last game</td>';
  $table_html .= '<td>Champions killed</td>';
  $table_html .= '<td>Champion level</td>';
  $table_html .= '<td>Damage dealt to champions</td>';
  $table_html .= '</tr>';

  foreach ($summoner_id_list as $region => $region_list) {
    foreach ($region_list as $summoner_id) {
      $result = json_decode($game_api->get_recent_game_data($summoner_id, $region), true);
        $recent_game = $result['games'][0];
        $recent_game_stats = $recent_game['stats'];
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
    }
  }

  $table_html .= '</table>';

  echo $table_html;
  echo '<br><br>';
}

require_once '/includes/footer.php';
