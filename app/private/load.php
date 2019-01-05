<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

if (!empty($includeStats)) {
  $stats = json_decode(file_get_contents("{$config["apiRoot"]}/aanmeldingen/"), true);
}

$logoHtml = "<img width='320px' src='{$config["appRoot"]}/assets/Provincie-Flevoland-logo-01-1.svg' alt='Provincie Flevoland wegen en vaarwegen'>";
