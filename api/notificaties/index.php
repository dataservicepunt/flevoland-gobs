<?php

switch ($_SERVER["REQUEST_METHOD"]) {
  case "POST":
    if ($input = $_POST) {
      // void
    } elseif ($input = json_decode(file_get_contents("php://input"))) {
      // void
    } else {
      header("HTTP/1.1 400 Bad Request");
      die;
    }
    header("Content-type: application/json");
    die(json_encode([
      "method" => "post",
      "values" => $input
    ]));
    break;
}
