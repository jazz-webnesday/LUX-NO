<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: register.php");
    exit();
}

include 'connect.php';

$email = $_SESSION['email'];

// Get current token balance
$stmt = $conn->prepare("SELECT tokens FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($tokens);
$stmt->fetch();
$stmt->close();

$message = "";
$success = false;

$tokenTypes = [
    'AU' => ['luxcoin' => 2000, 'pesos' => 7000],
    'ZNC' => ['luxcoin' => 777, 'pesos' => 2700],
    'NHE' => ['luxcoin' => 30,  'pesos' => 99],
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $selectedToken = $_POST['token_type'];

    if (!isset($tokenTypes[$selectedToken])) {
        $message = "❌ Invalid token type selected.";
    } else {
        $requiredTokens = $tokenTypes[$selectedToken]['luxcoin'];
        $equivalentPesos = $tokenTypes[$selectedToken]['pesos'];

        if ($requiredTokens > $tokens) {
            $message = "⚠️ Not enough tokens to cash out $selectedToken.";
        } else {
            // Deduct tokens
            $stmt = $conn->prepare("UPDATE users SET tokens = tokens - ? WHERE email = ?");
            $stmt->bind_param("is", $requiredTokens, $email);
            if ($stmt->execute()) {
                // Log transaction
                $stmt2 = $conn->prepare("INSERT INTO transaction (email, type, tokens, pesos) VALUES (?, ?, ?, ?)");
                $type = 'Withdraw Money';
                $stmt2->bind_param("ssid", $email, $type, $requiredTokens, $equivalentPesos);
                $stmt2->execute();
                $stmt2->close();

                $message = "✅ You cashed out <strong>$selectedToken</strong> for <strong>₱" . number_format($equivalentPesos, 2) . "</strong>.";
                $tokens -= $requiredTokens;
                $success = true;
            } else {
                $message = "❌ Something went wrong. Please try again.";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Withdraw by Token</title>
  <style>
     @font-face {
      font-family: "greats";
      src: url(fonts/Valorax-lg25V.otf);
    }
    @font-face {
      font-family: "2nd";
      src: url(fonts/Game\ Of\ Squids.otf);
    }
    body {
      font-family:'Times New Roman', Times, serif;
      background: url(images/cashout\ \(1\).png)no-repeat center center;
      background-size: cover;
      background-attachment: fixed; 
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 50px 20px;
      min-height: 100vh;
    }

    h1 {
       margin-bottom: 30px;
      font-size: 70px;
      color:rgb(255, 237, 248);
      text-shadow:
        0 0 10px rgb(255, 0, 157),
        0 0 10px rgb(255, 0, 157),
        0 0 10px rgb(255, 0, 157),
        0 0 10px rgb(255, 0, 157);
      font-family: "2nd";
      font-weight: normal;
      margin-bottom: 20px;
      color: rgb(255, 255, 255);
    }

    h4 {
      margin-top: 5px;
      font-family: "2nd";
      font-size: 20px;
      color: rgb(255, 255, 255);
      text-shadow: 0 0 20px rgb(255, 27, 175);
    }

    .card {
      background:rgba(30, 30, 46, 0.1);
      padding: 30px;
      margin-bottom: 100px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(255, 155, 223, 0.8);
      width: 100%;
      max-width: 400px;
      margin-top: 30px;
    }

    .balance {
      margin-bottom: 20px;
      font-size: 1.3rem;
      font-family: "2nd";
      color:rgb(255, 240, 252);
      text-shadow: 0 0 20px rgb(254, 58, 185);
      text-align: center;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-size: 1.2rem;
    }

    input[type="number"] {
      width: 94%;
      padding: 12px;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      margin-bottom: 15px;
      background: #2a2a3c;
      color: #fff;
    }

    button {
      width: 100%;
      padding: 12px;
      font-size: 1rem;
      background: linear-gradient(to right,rgb(255, 0, 157),rgb(254, 58, 185));
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.2s;
    }

    button:hover {
      transform: scale(1.03);
    }

    .message {
      margin-top: 15px;
      padding: 10px;
      border-radius: 8px;
      text-align: center;
      font-size: 1rem;
      font-weight: bold;
    }

    .message.success {
      background-color: #2ecc71;
      color: #000;
    }

    .message.error {
      background-color: #e74c3c;
      color: #fff;
    }

    a {
      margin-top: 25px;
      color: #ffcc00;
      text-decoration: none;
      font-size: 0.95rem;
    }

    a:hover {
      text-decoration: underline;
    }

     .back-button {
  background-color:rgba(18, 34, 40, 0.07);
  color: #cccccc;
  margin-top: 15px;
  padding: 12px 24px;
  border-radius: 10px;
  text-decoration: none;
  font-weight: bold;
  font-size: 15px;
  box-shadow: 
    0 0 10px #ff5050;

  transition: all 0.3s ease;
}

.back-button:hover {
  background-color:rgb(255, 0, 157);
  color: white;
  box-shadow:
    0 0 15px rgb(244, 165, 254),
    0 0 30px rgb(244, 165, 254);
  transform: scale(1.05);
}

select {
      width: 100%;
      padding: 12px;
      font-size: 1rem;
      border-radius: 6px;
      background: #2a2a3c;
      color: #fff;
      margin-bottom: 15px;
      border: none;
    }


  </style>
</head>
<body>

<h1>Withdraw</h1>
<h4>Select LuxCoin type to cash out</h4>

<div class="card">
  <div class="balance">Your Tokens: <strong><?= htmlspecialchars($tokens) ?></strong></div>

  <form method="POST" action="">
    <label for="token_type">Select:</label>
    <select name="token_type" id="token_type" required>
      <option value="">-- Choose LuxCoin --</option>
      <option value="AU">AU (2000 Tokens = ₱7000)</option>
      <option value="ZNC">ZNC (777 Tokens = ₱2700)</option>
      <option value="NHE">NHE (30 Tokens = ₱99)</option>
    </select>

    <button type="submit">Cash Out</button>

    <?php if ($message): ?>
      <div class="message <?= $success ? 'success' : 'error' ?>">
        <?= $message ?>
        <?php if ($success): ?>
          <audio autoplay><source src="sounds/cashout claim.wav" type="audio/mpeg"></audio>
        <?php else: ?>
          <audio autoplay><source src="error.mp3" type="audio/mpeg"></audio>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </form>
</div>

<a href="index.php" class="back-button">⬅ Back to Main</a>

</body>
</html>
