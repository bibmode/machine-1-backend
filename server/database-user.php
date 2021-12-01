<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . '/classes/Database.php';
$database = new Database();
$conn = $database->dbConnection();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->username)) :
  echo json_encode([
    'success' => 0,
    'message' => 'Please add a content.',
  ]);
  exit;

elseif (empty(trim($data->username))) :
  echo json_encode([
    'success' => 0,
    'message' => 'Oops! empty field detected. Please fill all the fields.',
  ]);
  exit;

endif;

try {
  $username = htmlspecialchars(trim($data->username));
  $password = htmlspecialchars(trim($data->password));
  $host = htmlspecialchars(trim($data->host));
  $grants = htmlspecialchars(trim($data->grants));
  $database = htmlspecialchars(trim($data->database));

  $query = "CREATE USER :username@:host IDENTIFIED BY :password";

  $stmt = $conn->prepare($query);

  $stmt->bindValue(':username', $username, PDO::PARAM_STR);
  $stmt->bindValue(':password', $password, PDO::PARAM_STR);
  $stmt->bindValue(':host', $host, PDO::PARAM_STR);

  if ($stmt->execute()) {

    $query2 = "GRANT $grants ON $database.* TO $username@$host";

    $stmt2 = $conn->prepare($query2);

    if ($stmt2->execute()) {
      echo json_encode([
        'success' => 1,
        'message' => 'added user to system.'
      ]);
      exit;
    }

    echo json_encode([
      'success' => 0,
      'message' => 'Data not Inserted.'
    ]);
    exit;
  }

  echo json_encode([
    'success' => 0,
    'message' => 'Data not Inserted.'
  ]);
  exit;
} catch (PDOException $e) {
  // http_response_code(500);
  echo json_encode([
    'success' => 0,
    'message' => $e->getMessage()
  ]);
  exit;
}
