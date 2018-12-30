<?php

header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");

include("../../private/load.php");

function formatNumber($telefoonnummer) {
  $telefoonnummer = preg_replace("/[^0-9]/", "", $telefoonnummer);
  $telefoonnummer = preg_replace(["/^00316/", "/^06/", "/^316/"], "+316", $telefoonnummer);
  return $telefoonnummer;
}

function validNumberFormat($telefoonnummer) {
  if (strpos($telefoonnummer, "+316") !== 0) {
    return false;
  }
  if (strlen($telefoonnummer) !== 12) {
    return false;
  }
  return true;
}

$request = [
  "datetime" => date("Y-m-d H:i:s"),
];

switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":
    $request["objecten"] = $subscriptionsStorage->getCounts();
    break;

  case "POST":
    if ($input = $_POST) {
      // void
    } elseif ($input = json_decode(file_get_contents("php://input"), true)) {
      // void
    } else {
      header("HTTP/1.1 400 Bad Request");
      break;
    }

    $request["telefoonnummer"] = formatNumber($input["telefoonnummer"]);
    $request["objecten"] = $input["objecten"];

    if (!validNumberFormat($request["telefoonnummer"])) {
      header("HTTP/1.1 400 Bad Request");
      $response = [
        "error" => "incorrect telefoonnummer",
        "telefoonnummer" => $request["telefoonnummer"]
      ];
      die(json_encode($response));
    }

    $subscriptionsStorage->save(
      $request["telefoonnummer"],
      $request["objecten"]
    );

    $subscriptionsLogStorage->save(
      $request["telefoonnummer"],
      $request["objecten"],
      $request["datetime"]
    );

    break;
}

die(json_encode($request));
