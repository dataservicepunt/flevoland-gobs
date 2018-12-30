<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

//FIXME Remove CDN dependency
$cdnRoot = "https://www.dataservicepunt.nl/flevoland";

if (!empty($includeStats)) {
  $stats = json_decode(file_get_contents("{$config["apiRoot"]}/aanmeldingen/"), true);
}

// FIXME Remove remote dependencies
$navHtml = "";//file_get_contents("{$cdnRoot}/partial_nav.html");
$footerHtml = "";//file_get_contents("{$cdnRoot}/partial_footer.html");
$logoHtml = '<img width="320px" src="https://flevowegen.nl/wp-content/uploads/Provincie-Flevoland-logo-01-1.svg" alt="Provincie Flevoland wegen en vaarwegen">';
