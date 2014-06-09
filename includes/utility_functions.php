<?php
/**
 * Functions with no other place to go.
 */

require_once '/includes/riot_constants.php';

/**
 * Get a variable from the request, with cleaning included.
 *
 * @param string $data_name The name of the variable to grab from the request.
 *
 * @return mixed The value for the variable in the request.
 */
function get_request_data($data_name) {
  if (array_key_exists($data_name, $_POST)) {
    // If the data is in POST.
    return clean_request_data($_POST[$data_name]);
  } elseif (array_key_exists($data_name, $_GET)) {
    // If the data is in GET.
    return clean_request_data($_GET[$data_name]);
  } else {
    // We couldn't find the data.
    return '';
  }
}

/**
 * Cleans out any unwanted characters from the request data.
 *
 * @param mixed $data The data to be cleaned.
 *
 * return mixed The cleaned data.
 */
function clean_request_data($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

/**
 * Creates a select drop down menu.
 *
 * @param array  $menu_data The list of options to display in the menu.
 * @param string $menu_name The name attribute for the menu.
 * @param string $selected  (Optional) The selected option on the menu.
 * @param string $default   (Optional) The default selected value in the menu, if $selected is empty.
 *
 * @return string The HTML for the menu.
 */
function build_menu($menu_data, $menu_name, $selected = '', $default_value = '') {
  // Start of the menu with the name attribute.
  $menu_html = '<select name="' . htmlentities($menu_name) . '">';

  if (empty($selected) && !empty($default_value)) {
    $selected = $default_value;
  }

  // Iterate through each option in the data and add it as an option on the menu.
  foreach ($menu_data as $option) {
    $selected_text = '';

    // If the current option is selected, add the selected attribute.
    if ($option == $selected) {
      $selected_text = 'selected="selected"';
    }

    // HTML for the option.
    $menu_html .= '<option value="' . htmlentities($option) . '" ' . $selected_text . '>' . htmlentities($option) . '</option>';
  }

  // Close the menu.
  $menu_html .= '</select>';

  return $menu_html;
}

/**
 * Tests if the page is the current page we are on.
 *
 * @param string $file_name The name of the page we are testing.
 *
 * @return bool True if the page is the current page we are on, false if it is not.
 */
function is_current_page($file_name) {
  return (basename($_SERVER['PHP_SELF']) == $file_name);
}

/**
 * Returns an array with the region constants.
 *
 * @return array An array of the region constants.
 */
function get_regions_list() {
  return array(REGION_BR, REGION_EUNE, REGION_EUW, REGION_KR, REGION_LAN, REGION_LAS, REGION_NA, REGION_OCE, REGION_RU, REGION_TR);
}

/**
 * Clears a cookie out of $_COOKIE and out of the browser.
 *
 * @param string The name of the cookie to clear.
 *
 * @return void
 */
function clear_cookie($cookie_name) {
  // Clear the cookie out of $_COOKIE.
  unset($_COOKIE[$cookie_name]);

  // Clear the cookie out of the browser by setting the value to empty and the expiration in the past.
  setcookie($cookie_name, '', time() - 3600);
}
