<?php

header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");

include("../../private/load.php");

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

    $request["telefoonnummer"] = $numberFunctions->formatNumber($input["telefoonnummer"]);
    $request["objecten"] = $input["objecten"];

    if (!$numberFunctions->validNumberFormat($request["telefoonnummer"])) {
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
