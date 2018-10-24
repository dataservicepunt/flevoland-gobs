<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");

include("../../private/config.php");

$request = [
  "datetime" => date("Y-m-d H:i:s"),
];

switch ($_SERVER["REQUEST_METHOD"]) {
  case "POST":
    if ($input = $_POST) {
      // void
    } elseif ($input = json_decode(file_get_contents("php://input"), true)) {
      // void
    } else {
      header("HTTP/1.1 400 Bad Request");
      break;
    }
    $request["telefoonnummer"] = $input["telefoonnummer"];
    $request["telefoonnummer"] = preg_replace("/[^0-9]/", "", $request["telefoonnummer"]);
    $request["telefoonnummer"] = preg_replace(["/^00316/", "/^06/", "/^316/"], "+316", $request["telefoonnummer"]);

    if (strpos($request["telefoonnummer"], "+316") !== 0 ||
        strlen($request["telefoonnummer"]) !== 12) {
      header("HTTP/1.1 400 Bad Request");
      $response = [
        "error" => "incorrect telefoonnummer",
        "telefoonnummer" => $request["telefoonnummer"]
      ];
      die(json_encode($response));
    }

    $request["objecten"] = $input["objecten"];

    if (!file_exists($config["subscriptionsFilePath"])) {
      copy("{$config["subscriptionsFilePath"]}.dist", $config["subscriptionsFilePath"]);
    }
    $subscriptions = json_decode(file_get_contents($config["subscriptionsFilePath"]), true);
    $subscriptions["subscriptions"][$request["telefoonnummer"]] = $request["objecten"];
    file_put_contents($config["subscriptionsFilePath"], json_encode($subscriptions));

    break;
}

die(json_encode($request));
