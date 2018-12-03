<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$cdnRoot = "https://www.dataservicepunt.nl/flevoland";

if (!empty($includeStats)) {
  $stats = json_decode(file_get_contents("{$config["apiRoot"]}/aanmeldingen/"), true);
}

// FIXME: CACHING
$navHtml = file_get_contents("{$cdnRoot}/partial_nav.html");
$footerHtml = file_get_contents("{$cdnRoot}/partial_footer.html");
