<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$cdnRoot = "https://www.dataservicepunt.nl/flevoland";

$provinciale_wegen_url = "{$cdnRoot}/data/provinciale_wegen/provinciale_wegen.geojson";
$provinciale_wegen = json_decode(file_get_contents($provinciale_wegen_url), true);

$bruggen_en_sluizen_url = "{$cdnRoot}/data/bruggen_en_sluizen/bruggen_en_sluizen.geojson";
$bruggen_en_sluizen = json_decode(file_get_contents($bruggen_en_sluizen_url), true);

$navHtml = file_get_contents("{$cdnRoot}/partial_nav.html");
$footerHtml = file_get_contents("{$cdnRoot}/partial_footer.html");

$mapping = json_decode(file_get_contents("../../private/mapping.json"), true);
