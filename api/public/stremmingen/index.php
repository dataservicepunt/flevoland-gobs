<?php

header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");

include("../../private/config.php");

$request = [
  "datetime" => date("Y-m-d H:i:s"),
];

switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":
    readfile($config["objectStatusFilePath"]);
    die;

  case "POST":
    if ($input = $_POST) {
      // void
    } elseif ($input = json_decode(file_get_contents("php://input"), true)) {
      // void
    } else {
      header("HTTP/1.1 400 Bad Request");
      break;
    }
    $request["object"] = $input["object"];
    $request["status"] = $input["status"];

    $userConfig = $config["users"][$input["username"]];
    if (empty($userConfig)) {
      header("HTTP/1.1 401 Unauthorized");
      $response = [
        "error" => "incorrecte gebruikersnaam en/of wachtwoord"
      ];
      die(json_encode($response));
    }

    if (empty($input["password"]) ||
        hash($userConfig["hashAlgorithm"], $input["password"]) !== strtolower($userConfig["passwordHash"])) {
      header("HTTP/1.1 401 Unauthorized");
      $response = [
        "error" => "incorrecte gebruikersnaam en/of wachtwoord"
      ];
      die(json_encode($response));
    }

    $request["senderId"] = $userConfig["id"];

    if (!file_exists($config["objectStatusLogFilePath"])) {
      copy("{$config["objectStatusLogFilePath"]}.dist", $config["objectStatusLogFilePath"]);
    }
    $objectStatusLog = json_decode(file_get_contents($config["objectStatusLogFilePath"]), true);
    $objectStatusLog["status_updates"][] = $request;
    file_put_contents($config["objectStatusLogFilePath"], json_encode($objectStatusLog));

    if (!file_exists($config["objectStatusFilePath"])) {
      copy("{$config["objectStatusFilePath"]}.dist", $config["objectStatusFilePath"]);
    }
    $objectStatus = json_decode(file_get_contents($config["objectStatusFilePath"]), true);
    $objectStatus["objecten"][$request["object"]] = $request["status"];
    file_put_contents($config["objectStatusFilePath"], json_encode($objectStatus));

    break;
}

die(json_encode($request));
