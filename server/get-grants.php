<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$data = json_decode(file_get_contents("php://input"));

if (!isset($data->username) && !isset($data->password) && !isset($data->host)) :
  echo json_encode([
    'success' => 0,
    'message' => 'Incomplete fields',
  ]);
  exit;

elseif (empty(trim($data->username))) :
  echo json_encode([
    'success' => 0,
    'message' => 'Incomplete fields',
  ]);
  exit;

endif;

try {
  $username = htmlspecialchars(trim($data->username));
  $host = htmlspecialchars(trim($data->host));
  $database = htmlspecialchars(trim($data->database));
  $password = htmlspecialchars(trim($data->password));

  $mysqli = new mysqli('localhost', 'genevieve', 'password');

  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
  }

  $result = $mysqli->query("SHOW GRANTS for $username@$host");

  while ($row = mysqli_fetch_array($result)) {
    echo json_encode($row);
  }

  exit;
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode([
    'success' => 0,
    'message' => $e->getMessage()
  ]);
  exit;
}
