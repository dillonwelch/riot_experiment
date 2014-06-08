<?php
/**
 * Functions with no other place to go.
 */

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
 * @param string $selected  (Optional) The selected option on the menu, if any.
 *
 * @return string The HTML for the menu.
 */
function build_menu($menu_data, $menu_name, $selected = '') {
  // Start of the menu with the name attribute.
  $menu_html = '<select name="' . htmlentities($menu_name) . '">';

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
