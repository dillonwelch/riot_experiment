<?php
/**
 * Helper class for making calls to the Summoner API.
 */

require_once '/includes/curl_helper.php';

class Summoner_API extends CURL_Helper {

  // The version number of this API.
  const VERSION_NUMBER = '1.4';

  // The base name of this API.
  const BASE_API_NAME = 'summoner';

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
   */
  public function get_summoner_by_name($summoner_name, $region) {
    $api_url = '/' . self::BASE_API_NAME . '/by-name/' . $this->clean_api_input($summoner_name);
    return $this->make_api_call($api_url, $region);
  }


}
