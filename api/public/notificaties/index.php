<?php

header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");

include("../../private/config.php");

$request = [
  "datetime" => date("Y-m-d H:i:s"),
];

function sendBatch($apiUrl, $accessToken, $originator, $smsText, $telefoonnummers) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $apiUrl);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: AccessKey {$accessToken}",
    "Accept: applications/json"
  ]);
  $postfields = [
    "originator" => $originator,
    "body" => $smsText,
    "recipients" => $telefoonnummers
  ];
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $rs = json_decode(curl_exec($ch));
  curl_close ($ch);
  return $rs;
}

switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":
    readfile($config["notificationsLogFilePath"]);

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
    $request["smsText"] = $input["notificatie"];
    $request["smsLength"] = strlen($request["smsText"]);
    $request["objecten"] = $input["objecten"];

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

    // log the message
    if (!file_exists($config["notificationsLogFilePath"])) {
      copy("{$config["notificationsLogFilePath"]}.dist", $config["notificationsLogFilePath"]);
    }
    $notificationsLog = json_decode(file_get_contents($config["notificationsLogFilePath"]), true);
    $notificationsLog["notifications"][] = $request;
    file_put_contents($config["notificationsLogFilePath"], json_encode($notificationsLog));

    $subscriptions = json_decode(file_get_contents($config["subscriptionsFilePath"]), true);
    $telefoonnummers = [];
    foreach ($request["objecten"] as $object) {
      foreach ($subscriptions["subscriptions"] as $telefoonnummer => $objecten) {
        if (in_array($object, $objecten)) {
          $telefoonnummers[$telefoonnummer] = true;
        }
      }
    }
    $request["telefoonnummers"] = array_keys($telefoonnummers);

    if (empty($telefoonnummers)) {
      header("HTTP/1.1 400 Bad Request");
      $response = [
        "error" => "geen telefoonnummers om sms naar te versturen"
      ];
      die(json_encode($response));
    }

    for ($i = 0; $i < count($request["telefoonnummers"]); $i += 50) {
      $telefoonnummers = array_slice($request["telefoonnummers"], $i, 50);
      $request["rss"][] = sendBatch(
        $config["apiUrl"],
        $userConfig["accessToken"],
        $config["originator"],
        $request["smsText"],
        $telefoonnummers
      );
    }

    $request["rs"] = reset($request["rss"]); // To-do: remove legacy (interface pop-up)
    break;
}

die(json_encode($request));
