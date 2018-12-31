<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

include(__DIR__ . "/config.php");

$pdo = new PDO(
  "mysql:host={$config["db"]["host"]};dbname={$config["db"]["name"]}",
  $config["db"]["user"],
  $config["db"]["pass"]
);

include(__DIR__ . "/classes/UsersStorage.php");
$usersStorage = new UsersStorage($config, $pdo);

include(__DIR__ . "/classes/SubscriptionsStorage.php");
$subscriptionsStorage = new SubscriptionsStorage($config, $pdo);

include(__DIR__ . "/classes/SubscriptionsLogStorage.php");
$subscriptionsLogStorage = new SubscriptionsLogStorage($config, $pdo);

include(__DIR__ . "/classes/NotificationsStorage.php");
$notificationsStorage = new NotificationsStorage($config, $pdo);

include(__DIR__ . "/classes/Sender.php");
$sender = new Sender($config, $pdo);
