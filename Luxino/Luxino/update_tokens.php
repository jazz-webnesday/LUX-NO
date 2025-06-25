<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
  http_response_code(401);
  echo json_encode(["error" => "Not logged in"]);
  exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$change = floatval($data["change"]);
$email = $_SESSION['email'];

$query = $conn->prepare("UPDATE users SET tokens = tokens + ? WHERE email = ?");
$query->bind_param("ds", $change, $email);
$success = $query->execute();

if ($success) {
  echo json_encode(["success" => true]);
} else {
  http_response_code(500);
  echo json_encode(["error" => "Failed to update tokens"]);
}
?>
