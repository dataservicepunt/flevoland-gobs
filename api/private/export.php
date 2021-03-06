<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

include(__DIR__ . "/config.php");

$pdo = new PDO(
  "mysql:host={$config["db"]["host"]};dbname={$config["db"]["name"]}",
  $config["db"]["user"],
  $config["db"]["pass"]
);

echo "notifications\n\n";
$stmt = $pdo->prepare('SELECT * FROM notifications');
$stmt->execute();
$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rs as $r) {
	echo '"' . implode('","', $r) . "\"\n";
}
echo "\n\n\n";

echo "users\n\n";
$stmt = $pdo->prepare('SELECT * FROM users');
$stmt->execute();
$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rs as $r) {
	echo '"' . implode('","', $r) . "\"\n";
}
echo "\n\n\n";

echo "subscriptions\n\n";
$stmt = $pdo->prepare('SELECT * FROM subscriptions');
$stmt->execute();
$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rs as $r) {
	echo '"' . implode('","', $r) . "\"\n";
}
echo "\n\n\n";

echo "subscriptions_log\n\n";
$stmt = $pdo->prepare('SELECT * FROM subscriptions_log');
$stmt->execute();
$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rs as $r) {
	echo '"' . implode('","', $r) . "\"\n";
}
echo "\n\n\n";
