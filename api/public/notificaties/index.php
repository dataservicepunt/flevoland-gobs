<?php

header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");

include("../../private/config.php");

$request = [
  "datetime" => date("Y-m-d H:i:s"),
];

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

    if (empty($input["token"]) || sha1($input["token"]) !== $config["users"]["default"]) {
      header("HTTP/1.1 401 Unauthorized");
      $response = [
        "error" => "incorrecte token"
      ];
      die(json_encode($response));
    }

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
    $postfields = [
      "recipients" => $request["telefoonnummers"],
      "originator" => $config["originator"],
      "body" => $request["smsText"],
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $config["apiUrl"]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Authorization: AccessKey {$config["accessToken"]}",
      "Accept: applications/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $request["rs"] = json_decode(curl_exec($ch));
    curl_close ($ch);

    break;
}

die(json_encode($request));
