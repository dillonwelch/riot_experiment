<?php
/**
 * Helper class for making calls to the Game API.
 */

require_once '/includes/curl_helper.php';

class Game_API extends CURL_Helper {

  // The version number of this API.
  const VERSION_NUMBER = '1.3';

  // The base name of this API.
  const BASE_API_NAME = 'game';

  /**
   * Constructor.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();

    // Set the version number of this API.
    $this->version_number = self::VERSION_NUMBER;
  }

  /**
   * Make a call to the 'by-name' operation.
   *
   * @param int    $summoner_id The ID of the summoner we are looking up.
   * @param string $region The region that $summoner_id is located in.
   *
   * @return array The result of the API call.
   */
  public function get_recent_game_data($summoner_id, $region) {
    $api_url = '/' . self::BASE_API_NAME . '/by-summoner/' . $this->clean_api_input($summoner_id) . '/recent';
    return $this->make_api_call($api_url, $region);
  }


}
