<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$json = file_get_contents("https://www.dataservicepunt.nl/flevoland/data/bruggen_en_sluizen/bruggen_en_sluizen.geojson");
$data = json_decode($json, true);

$rs = [];

foreach ($data["features"] as $feature) {
  if (strpos(strtolower($feature["properties"]["naam"]), "brug") !== false) {
    $rs["bruggen"][$feature["properties"]["nummer"]] = $feature["properties"]["naam"];
  } else if (strpos(strtolower($feature["properties"]["naam"]), "sluis") !== false) {
    $rs["sluizen"][$feature["properties"]["nummer"]] = $feature["properties"]["naam"];
  }
}

$json = file_get_contents("https://www.dataservicepunt.nl/flevoland/data/provinciale_wegen/provinciale_wegen.geojson");
$data = json_decode($json, true);

foreach ($data["features"] as $feature) {
  $rs["wegen"][$feature["properties"]["NAAM"]] = $feature["properties"]["N_WEG"];
}

header("Content-type: application/json");
echo json_encode($rs);
