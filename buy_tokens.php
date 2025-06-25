<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: register.php");
    exit();
}

include 'connect.php';
$email = $_SESSION['email'];
$success = false;
$error = "";

// Get current token balance
$result = $conn->prepare("SELECT tokens FROM users WHERE email = ?");
$result->bind_param("s", $email);
$result->execute();
$result->bind_result($currentTokens);
$result->fetch();
$result->close();

// Coin data
$coinOptions = [
    'NHE' => ['tokens' => 30, 'pesos' => 99],
    'AU'  => ['tokens' => 2000, 'pesos' => 7000],
    'ZNC' => ['tokens' => 777, 'pesos' => 2700],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_coin'])) {
    $selectedCoin = $_POST['buy_coin'];

    if (array_key_exists($selectedCoin, $coinOptions)) {
        $tokensToAdd = $coinOptions[$selectedCoin]['tokens'];
        $pesosSpent = $coinOptions[$selectedCoin]['pesos'];

        // Update user's token balance
        $stmt = $conn->prepare("UPDATE users SET tokens = tokens + ? WHERE email = ?");
        $stmt->bind_param("is", $tokensToAdd, $email);
        $stmt->execute();
        $stmt->close();

        // Record transaction
        $stmt = $conn->prepare("INSERT INTO transaction (email, type, tokens, pesos) VALUES (?, 'Bought Tokens', ?, ?)");
        $stmt->bind_param("sii", $email, $tokensToAdd, $pesosSpent);
        $stmt->execute();
        $stmt->close();

        $success = true;
        $currentTokens += $tokensToAdd;
    } else {
        $error = "Invalid coin selection.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Buy Tokens</title>
 <style>
    @font-face {
      font-family: "greats";
      src: url(fonts/Valorax-lg25V.otf);
    }
    @font-face {
      font-family: "2nd";
      src: url('fonts/Game\ Of\ Squids.otf');
    }
    @import url('https://fonts.googleapis.com/css2?family=Quantico:ital,wght@0,400;0,700;1,400;1,700&display=swap');

    body {
      background: url(images/token\ trans\ bg.png);
      background-size: cover;
      color: #fff;
      text-align: center;
      padding-top: 60px;
      margin: 0;
    }

    .balance {
      font-size: 35px;
      font-family: "2nd";
      margin-top: 10px;
      margin-bottom: 30px;
    }

    .coin-option {
      display: inline-block;
      margin: 20px;
      padding: 20px;
      border: 2px solid rgb(255, 165, 237);
      border-radius: 15px;
      background-color: rgba(0, 0, 0, 0.5);
      box-shadow: 0 0 20px rgb(255, 165, 237);
      cursor: pointer;
      transition: transform 0.2s ease;
    }

    .coin-option:hover {
      transform: scale(1.05);
      box-shadow: 0 0 25px rgb(250, 158, 239);
    }

    .coin-option img {
      width: 130px;
      height: 130px;
      margin-bottom: 1px;
    }

    .info-box {
      margin-top: 20px;
      font-size: 20px;
      font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
      font-weight: normal;
    }

    .buy-btn {
      margin-top: 20px;
      padding: 12px 30px;
      font-size: 1rem;
      background: linear-gradient(to right,rgb(255, 0, 157),rgb(254, 58, 185));
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      display: none;
    }
    /* MESSAGE STYLES */
      .message {
        font-size: 20px;
        margin-top: 20px;
        padding: 12px 18px;
        border-radius: 10px;
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
        box-shadow: 0 0 10px rgba(0,255,247,0.3);
      }

      .success {
        background-color: rgba(0, 255, 136, 0.1);
        border: 2px solid #00ff88;
        color: #00ff88;
      }

      .error {
        background-color: rgba(255, 80, 80, 0.1);
        border: 2px solid #ff5050;
        color: #ff5050;
      }

      .info {
        background-color: rgba(255, 204, 0, 0.1);
        border: 2px solid #ffcc00;
        color: #ffcc00;
      }

      /* FONT ADJUSTMENTS */
     h2 {
      font-family: "2nd", sans-serif;
      font-size: 60px;
      color: #fff;
      text-shadow: 0 0 20px rgb(254, 58, 185);
      }

     p {
      font-family: "2nd", sans-serif;
      font-size: 1rem;
      font-weight: 400;
      color: rgb(255, 229, 252); /* Optional color */
     }

     strong {
     font-family: "2nd", sans-serif;
     font-weight: bold;
     font-size: 1.5rem;
     color:rgb(255, 176, 250); /* Optional color */
     text-shadow: 0 0 20px rgb(255, 27, 175);
     }

     .balance {
       font-size: 30px;
       font-family: "2nd";
       color: #fff;
       text-shadow: 0 0 20px rgb(255, 27, 175);
       margin: 10px 0 30px;
      }

    .back-button {
      background-color: rgba(18, 34, 40, 0.07);
      color: #cccccc;
      padding: 12px 24px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: bold;
      font-size: 15px;
      box-shadow: 0 0 10px #ff5050;
      transition: all 0.3s ease;
      margin-top: 30px;
      margin-bottom: 50px;
      display: inline-block;
    }

    .back-button:hover {
      background-color: rgb(255, 0, 157);
      color: white;
      box-shadow: 
      0 0 15px rgb(250, 158, 239), 
      0 0 30px rgb(250, 158, 239)7;
      transform: scale(1.05);
    }
  </style>
</head>
<body>

<h2>Buy LuxCoin</h2>


<?php if ($success): ?>
  <p class="message success"><?= $tokensToAdd; ?> LuxCoins successfully added!</p>
  <audio autoplay><source src="sounds/mixkit-gold-coin-prize-1999.wav" type="audio/mpeg"></audio>
 
<?php elseif ($error): ?>
  <p class="message error">❌ <?= htmlspecialchars($error) ?></p>
  <audio autoplay><source src="error.mp3" type="audio/mpeg"></audio>
<?php endif; ?>

<!-- Coin Selection UI -->
<div class="coin-option" onclick="selectCoin('NHE', 30, 99)">
  <img src="images/NHE (1).png" alt="NHE Coin">
  <p><strong>NHE</strong><br>₱99 = 30 Tokens</p>
</div>

<div class="coin-option" onclick="selectCoin('AU', 2000, 7000)">
  <img src="images/AU (1).png" alt="AU Coin">
  <p><strong>AU</strong><br>₱7000 = 2000 Tokens</p>
</div>

<div class="coin-option" onclick="selectCoin('ZNC', 777, 2700)">
  <img src="images/777.png" alt="ZNC Coin">
  <p><strong>ZNC</strong><br>₱2700 = 777 Tokens</p>
</div>

<div class="balance">Balance: <?= number_format($currentTokens) ?> Tokens</div>

<!-- Selected Coin Info and Buy Button -->
<div class="info-box" id="coinInfo"></div>

<form method="POST" id="buyForm" style="margin-top: 10px;">
  <input type="hidden" name="buy_coin" id="buy_coin" />
  <button type="submit" class="buy-btn" id="buyBtn">Buy</button>
</form>

<a href="index.php" class="back-button">⬅ Back to Main</a>

<script>
  function selectCoin(coin, tokens, pesos) {
    document.getElementById("buy_coin").value = coin;
    document.getElementById("coinInfo").innerHTML =
      `<strong>Selected Coin:</strong> ${coin}<br>` +
      `<strong>Amount of Tokens:</strong> ${tokens}<br>` +
      `<strong>Cost:</strong> ₱${pesos}`;
    document.getElementById("buyBtn").style.display = "inline-block";
  }
</script>

</body>
</html>
