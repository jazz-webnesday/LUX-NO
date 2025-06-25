<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: register.php");
  exit();
}

include 'connect.php';

$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT type, tokens, pesos, created_at FROM transaction WHERE email = ? ORDER BY created_at DESC");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Transaction History</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap');

    body {
      font-family: 'Orbitron', sans-serif;
      background: linear-gradient(120deg,rgb(255, 222, 7),rgb(253, 245, 0));
      color: #f0f0f0;
      padding: 40px;
      background-image: url('images/sendtoken.png'); /* optional background image */
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }

    h2 {
      text-align: center;
      color: #ffe100;
      font-size: 42px;
      text-shadow: 0 0 15px #ffcc00;
      margin-bottom: 20px;
    }

    table {
    width: 100%;
    border-collapse: collapse;
    margin: 30px 0;
    background-color: rgba(51, 9, 31, 0.5);
    box-shadow: 0 0 20px rgba(150, 11, 113, 0.35);
    border-radius: 12px;
    overflow: hidden;
  }

    th, td {
      padding: 14px 16px;
      text-align: center;
      border-bottom: 1px solid #444;
    }

    th {
      background-color: #222;
      color: #ffcc00;
      font-size: 16px;
      letter-spacing: 1px;
      text-shadow: 0 0 6px #ffcc00;
    }

    tr:nth-child(even) {
    background-color: rgba(71, 20, 52, 0.5);;
  }

  tr:hover {
    background-color: rgba(218, 87, 196, 0.05);
    box-shadow: inset 0 0 10px #00fff7;
    transition: 0.3s ease-in-out;
  }

    td {
      font-size: 15px;
    }

    .back-btn {
      display: inline-block;
      margin: 40px auto 0;
      padding: 12px 24px;
      background: linear-gradient(to right, #ff9900, #ffcc00);
      color: #000;
      font-weight: bold;
      font-size: 16px;
      text-decoration: none;
      border-radius: 8px;
      box-shadow: 0 0 10px #ffcc00, 0 0 20px #ffcc00 inset;
      transition: all 0.3s ease;
      text-align: center;
    }

    .back-btn:hover {
      background: linear-gradient(to right, #ffaa00, #ffff00);
      transform: scale(1.05);
      box-shadow: 0 0 20px #ffcc00, 0 0 30px #ffcc00 inset;
      color: #000;
    }
</style>

</head>
<body>

  <h2>Your Transaction History</h2>
  <a class="back-btn" href="index.php">⬅ Back to Home</a>
  <table>
    <tr>
      <th>Type</th>
      <th>Tokens</th>
      <th>Amount</th>
      <th>Date</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['type']) ?></td>
        <td> <?= (int)$row['tokens'] ?></td>
        <td> ₱<?= (int)$row['pesos'] ?></td>
        <td><?= date("F j, Y, g:i a", strtotime($row['created_at'])) ?></td>
      </tr>
    <?php endwhile; ?>

  </table>
  </table>

  <!-- TOKEN TRANSFER HISTORY -->
<h2 style="margin-top: 60px;">Token Transfer History</h2>

<table>
  <tr>
    <th>Date</th>
    <th>Type</th>
    <th>User</th>
    <th>Token</th>
  </tr>

  <?php
  // Get current user's user_id
  $stmtUserId = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
  $stmtUserId->bind_param("s", $email);
  $stmtUserId->execute();
  $userIdResult = $stmtUserId->get_result();

  if ($userIdResult->num_rows > 0) {
    $currentUserID = $userIdResult->fetch_assoc()['user_id'];

    // Get token transactions where current user is sender or receiver
    $stmtTokens = $conn->prepare("SELECT * FROM token_transactions WHERE sender_id = ? OR receiver_id = ? ORDER BY created_at DESC");
    $stmtTokens->bind_param("ss", $currentUserID, $currentUserID);
    $stmtTokens->execute();
    $tokenResults = $stmtTokens->get_result();

    while ($row = $tokenResults->fetch_assoc()) {
      $isSender = ($row['sender_id'] === $currentUserID);
      $direction = $isSender ? "to" : "from";
      $otherUserID = $isSender ? $row['receiver_id'] : $row['sender_id'];

      // Fetch the email or name of the other user (optional)
      $stmtOtherUser = $conn->prepare("SELECT email FROM users WHERE user_id = ?");
      $stmtOtherUser->bind_param("s", $otherUserID);
      $stmtOtherUser->execute();
      $otherUserResult = $stmtOtherUser->get_result();
      $otherUserEmail = $otherUserResult->num_rows > 0 ? $otherUserResult->fetch_assoc()['email'] : 'Unknown';

      $tokenDisplay = $row['token_quantity'] . " " . $row['token_type'];
      $typeLabel = $isSender ? "Sent" : "Received";
      $typeColor = $isSender ? "#ff4d4d" : "#4dff4d";
  ?>
    <tr>
      <td><?= date("F j, Y, g:i a", strtotime($row['created_at'])) ?></td>
      <td style="color: <?= $typeColor ?>; font-weight:bold;"><?= $typeLabel ?></td>
      <td><?= $direction ?> <?= htmlspecialchars($otherUserEmail) ?></td>
      <td><?= htmlspecialchars($tokenDisplay) ?></td>
    </tr>
  <?php
    }
  } else {
    echo "<tr><td colspan='4'>User not found.</td></tr>";
  }
  ?>
</table>

</body>
</html>
