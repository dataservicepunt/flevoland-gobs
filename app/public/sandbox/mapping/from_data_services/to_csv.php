<?php

$data = json_decode(file_get_contents("../../private/mapping.json"), true);

foreach ($data["wegen"] as $key => $val) {
  echo $key . "," . implode($val, ",") . "\n";
}
foreach ($data["bruggen"] as $key => $val) {
  echo "{$key}, {$val}\n";
}
foreach ($data["sluizen"] as $key => $val) {
  echo "{$key}, {$val}\n";
}
