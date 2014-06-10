<?php
/**
 * Helper class for making cURL calls to Riot API.
 */

class CURL_Helper {

  // The base URL of all API calls.
  const BASE_API_URL = 'api.pvp.net/api/lol/';

  // API key that needs to be passed along with all calls.
  const API_KEY = '25f78534-b9f9-43de-93c4-a371dad3066c';

  // The location of the Riot API CA cert to verify the identity of the server.
  const CERT_LOCATION = '/cert/riot_cert.cer';

  // Instance of cURL object.
  private $curl_instance;

  // URL of the API we are requesting.
  private $url;

  // Version number of the API we are making the call to. Set in the child API class.
  protected $version_number;

  // If the last call made was successful.
  public $b_successful_call;

  /**
   * Constructor.
   *
   * @return void
   */
  public function __construct() {
    // Create a cURL object to use.
    $this->curl_instance = curl_init();
  }

  /**
   * Destructor.
   *
   * @return void
   */
  public function __destruct() {
    // Close out the cURL object.
    curl_close($this->curl_instance);
  }

  /**
   * Does any cleaning necessary to make input cooperate with Riot's API.
   *
   * @param mixed $input The input to be cleaned.
   *
   * @return mixed The cleaned input.
   */
  protected function clean_api_input($input) {
    // Strip any spaces out of the input and encode any special html characters.
    return htmlentities(str_replace(' ', '', $input));
  }

  /**
   * Generic function for making a Riot API call.
   *
   * @param string $api_url The URL for the API to call.
   * @param string $region  The region we are making the API call to.
   *
   * @return array The result of the API call.
   */
  public function make_api_call($api_url, $region) {
    $this->url = 'https://' . $region . '.' . self::BASE_API_URL . $region . '/v' . $this->version_number . $api_url . '?api_key=' . self::API_KEY;

    // Set the cURL options for the call.
    $this->set_curl_options();

    // Make the API call.
    $result = json_decode(curl_exec($this->curl_instance), true);

    // Check the status.
    if (!empty($result['status'])) {
      $this->b_successful_call = false;
    } else {
      $this->b_successful_call = true;
    }

    return $result;
  }

  /**
   * Sets all necessary settings on the cURL object.
   *
   * @return void
   */
  private function set_curl_options() {
    // Sets the URL for the request.
    curl_setopt($this->curl_instance, CURLOPT_URL, $this->url);

    // Don't include the response header in the output.
    curl_setopt($this->curl_instance, CURLOPT_HEADER, 0);

    // Saves the result as a string instead of displaying on screen.
    curl_setopt($this->curl_instance, CURLOPT_RETURNTRANSFER, 1);

    // Set settings related to SSL.
    $this->set_ssl_settings();
  }

  /**
   * Sets up SSL settings to be able to read from Riot's HTTPS API servers.
   *
   * @return void
   */
  private function set_ssl_settings() {
    // Verify that the server cert is valid.
    curl_setopt($this->curl_instance, CURLOPT_SSL_VERIFYPEER, true);

    // Check that the common name exists and it matches the server's host name>
    curl_setopt($this->curl_instance, CURLOPT_SSL_VERIFYHOST, 2);

    // Get the CA info from the cert downloaded from a Riot API results page.
    curl_setopt($this->curl_instance, CURLOPT_CAINFO, getcwd() . self::CERT_LOCATION);
  }

}
