<?php

header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");

include("../../private/load.php");

$request = [
  "datetime" => date("Y-m-d H:i:s"),
];

switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":
    $notifications = $notificationsStorage->get();
    die(json_encode($notifications));

  case "POST":
    if ($input = $_POST) {
      // void
    } elseif ($input = json_decode(file_get_contents("php://input"), true)) {
      // void
    } else {
      header("HTTP/1.1 400 Bad Request");
      break;
    }

    $request["smsText"] = $input["notificatie"];
    $request["smsLength"] = strlen($request["smsText"]);
    $request["objecten"] = $input["objecten"];

    $userConfig = $usersStorage->get($input["username"], $input["password"]);
    if (empty($userConfig)) {
      header("HTTP/1.1 401 Unauthorized");
      $response = [
        "error" => "incorrecte gebruikersnaam en/of wachtwoord"
      ];
      die(json_encode($response));
    }

    $request["senderId"] = $userConfig["id"];

    $notificationsStorage->save($request); //FIXME Define attributes

    $request["telefoonnummers"] = $subscriptionsStorage->getByObjects($request["objecten"]);
    if (empty($request["telefoonnummers"])) {
      header("HTTP/1.1 400 Bad Request");
      $response = [
        "error" => "geen telefoonnummers om sms naar te versturen"
      ];
      die(json_encode($response));
    }

    $sender->setAccessToken($userConfig["accessToken"]);

    $request["rss"] = $sender->send($request["telefoonnummers"], $request["smsText"]);

    $request["rs"] = reset($request["rss"]); //FIXME Remove legacy (interface error pop-up)
    break;
}

die(json_encode($request));
