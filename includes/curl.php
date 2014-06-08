<?php
/**
 * Helper class for making cURL calls to Riot API.
 */

class CURLHelper {

  // The base URL of all API calls.
  const BASE_API_URL = 'https://na.api.pvp.net/api/lol/';

  // API key that needs to be passed along with all calls.
  const API_KEY = '25f78534-b9f9-43de-93c4-a371dad3066c';

  const CERT_LOCATION = '/cert/riot_cert.cer';

  private $curl_instance;

  private $url;

  public function __construct($summoner_name) {
    $this->curl_instance = curl_init();
    // TODO make the na and 1.4 be params
    $this->url = self::BASE_API_URL . 'na/v1.4/summoner/by-name/' . $summoner_name . '?api_key=' . self::API_KEY;
  }

  public function make_api_call() {
    $this->set_curl_options();
    $this->set_ssl_settings();

    $result = curl_exec($this->curl_instance);
    curl_close($this->curl_instance);

    return $result;
  }

  private function set_curl_options() {
    curl_setopt($this->curl_instance, CURLOPT_URL, $this->url);
    curl_setopt($this->curl_instance, CURLOPT_HEADER, 0);
    curl_setopt($this->curl_instance, CURLOPT_RETURNTRANSFER, 1);
  }

  /**
   * Sets up SSL settings to be able to read from Riot's HTTPS API servers.
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
