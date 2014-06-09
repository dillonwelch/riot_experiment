<html>
<h1> Dillon's Riot Site </h1>
<body>

<?php
// If we are not on the index page, add a link back to the index page.
if (!(is_current_page('index.php'))) {
  ?>
  <a href="/riot_experiment/index.php">Back to home page</a>
  <br><br>
  <?php
}
