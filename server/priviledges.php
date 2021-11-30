<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$user = null;
$password = null;
$host = null;

if (isset($_GET['user']) && isset($_GET['password']) && isset($_GET['host'])) {
  $user = $_GET['user'];
  $password = $_GET['password'];
  $host = $_GET['host'];
}

$mysqli = new mysqli($host, $user, $password);

if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}

$result = $mysqli->query("SHOW GRANTS for $user@$host");

while ($row = mysqli_fetch_array($result)) {
  echo json_encode($row[0]);
}
