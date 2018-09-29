<?php

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

