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

  // Region that we are making the API call to.
  private $region;

  // Version number of the API we are making the call to. Set in the child API class.
  protected $version_number;

  /**
   * Constructor.
   *
   * @return void
   */
  public function __construct($region) {
    // Create a cURL object to use.
    $this->curl_instance = curl_init();

    $this->region = $region;
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
    // Strip any spaces out of the input.
    return str_replace(' ', '', $input);
  }

  public function make_api_call($api_url) {
    // TODO make the na and 1.4 be params
    $this->url = 'https://' . $this->region . '.' . self::BASE_API_URL . $this->region . '/v' . $this->version_number . $api_url . '?api_key=' . self::API_KEY;

    // TODO remove.
    var_dump($this->url);
    echo '<br>';

    // Set the cURL options for the call.
    $this->set_curl_options();

    // TODO check for response codes
    $result = curl_exec($this->curl_instance);

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
