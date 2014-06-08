<?php
/**
 * Functions with no other place to go.
 */

// TODO sanitize inputs?
function get_request_data($data_name) {
  if (array_key_exists($data_name, $_POST)) {
    return htmlspecialchars(stripslashes(trim($_POST[$data_name])));
  } elseif (array_key_exists($data_name, $_GET)) {
    return htmlspecialchars(stripslashes(trim($_GET[$data_name])));
  } else {
    return '';
  }
}
