<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
  http_response_code(401);
  echo json_encode(["error" => "Not logged in"]);
  exit();
}

$email = $_SESSION['email'];

$query = $conn->prepare("SELECT tokens FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();

echo json_encode(["tokens" => intval($row['tokens'])]);
?>
