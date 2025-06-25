<?php
session_start();
include 'connect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['email'])) {
    die("Unauthorized access");
}

$currentUserEmail = $_SESSION['email'];

// Get current user info
$getUser = $conn->prepare("SELECT user_id, tokens, password FROM users WHERE email = ?");
$getUser->bind_param("s", $currentUserEmail);
$getUser->execute();
$result = $getUser->get_result();

if ($result->num_rows === 0) {
    die("❌ User not found.");
}

$currentUser = $result->fetch_assoc();
$userId = $currentUser['user_id'];
$userTokens = $currentUser['tokens'];
$storedPassword = $currentUser['password'];

// Message variables
$message = "";
$messageType = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiver_id = $_POST['receiver_id'];
    $token_type = $_POST['token_type'];
    $enteredPassword = $_POST['password'];

    // DEBUG
    // echo "Entered Password: $enteredPassword<br>Stored Hash: $storedPassword<br>";

    // ✅ If you're using password_hash() and password_verify():
    if (md5($enteredPassword) !== $storedPassword) {

        $message = "❌ Incorrect password. Transfer cancelled.";
        $messageType = "error";
    } else {
        // Token amounts
        $tokenMap = [
            "NHE" => 30,
            "AU" => 2000,
            "ZNC" => 777
        ];

        // Check token type
        if (!isset($tokenMap[$token_type])) {
            $message = "❌ Invalid token type.";
            $messageType = "error";
        } else {
            $amount = $tokenMap[$token_type];

            if ($userTokens < $amount) {
                $message = "❌ Insufficient balance.";
                $messageType = "error";
            } else {
                // Check receiver exists
                $checkReceiver = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
                $checkReceiver->bind_param("s", $receiver_id);
                $checkReceiver->execute();
                $receiverResult = $checkReceiver->get_result();

                if ($receiverResult->num_rows === 0) {
                    $message = "❌ Receiver not found.";
                    $messageType = "error";
                } else {
                    // Start transaction
                    $conn->begin_transaction();

                    try {
                        // Deduct from sender
                        $deduct = $conn->prepare("UPDATE users SET tokens = tokens - ? WHERE email = ?");
                        $deduct->bind_param("is", $amount, $currentUserEmail);
                        $deduct->execute();

                        // Add to receiver
                        $add = $conn->prepare("UPDATE users SET tokens = tokens + ? WHERE user_id = ?");
                        $add->bind_param("is", $amount, $receiver_id);
                        $add->execute();

                        // Log transaction
                        $log = $conn->prepare("INSERT INTO token_transactions (sender_id, receiver_id, token_type, token_quantity) VALUES (?, ?, ?, ?)");
                        $log->bind_param("sssi", $userId, $receiver_id, $token_type, $amount);
                        $log->execute();

                        $conn->commit();

                        $message = "✅ Sent $amount LuxCoins ($token_type) to user ID: $receiver_id";
                        $messageType = "success";

                        // Update token balance for display
                        $userTokens -= $amount;
                    } catch (Exception $e) {
                        $conn->rollback();
                        $message = "❌ Transaction failed: " . $e->getMessage();
                        $messageType = "error";
                    }
                }
            }
        }
    }
}
?>



<!-- Casino-style CSS -->
<style>
  @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap');

  body {
    font-family: 'Orbitron', sans-serif;
    background: linear-gradient(120deg, #000000, #1c1c1c);
    background-image: url('images/sendtoken.png');
    background-size: cover;
    background-position: center;
    color: #f0f0f0;
    padding-top: 80px;
    text-align: center;
  }

  h2 {
    font-size: 36px;
    color: #ffcc00;
    text-shadow: 0 0 10px #00fff7, 0 0 20px #ffcc00;
    margin-bottom: 30px;
  }

  form {
    max-width: 420px;
    margin: auto;
    padding: 30px;
    background: rgba(10, 10, 10, 0.85);
    border: 2px solid #ffcc00;
    border-radius: 16px;
    box-shadow: 0 0 25px #ffcc00;
    backdrop-filter: blur(10px);
  }

  label {
    display: block;
    text-align: left;
    font-size: 16px;
    margin-bottom: 6px;
    color: #00fff7;
  }

  input[type="text"],
  select {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    background-color: #1e1e1e;
    color: #fff;
    box-shadow: inset 0 0 8px #00fff7;
  }
    input[type="password"],
  select {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    background-color: #1e1e1e;
    color: #fff;
    box-shadow: inset 0 0 8px #00fff7;
  }

  button[type="submit"] {
    width: 100%;
    padding: 14px;
    font-size: 18px;
    font-weight: bold;
    background: linear-gradient(to right, #ff00cc, #ffcc00);
    border: none;
    border-radius: 10px;
    color: #000;
    cursor: pointer;
    box-shadow: 0 0 12px #ffcc00, 0 0 20px #ff00cc;
    transition: all 0.3s ease;
  }

  button[type="submit"]:hover {
    transform: scale(1.05);
    background: linear-gradient(to right, #ffff00, #ff0077);
    box-shadow: 0 0 25px #00fff7;
  }

  .back-button {
    display: inline-block;
    margin-top: 40px;
    margin-bottom: 40px;
    background: #1e1e1e;
    color: #cccccc;
    padding: 12px 24px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: bold;
    font-size: 15px;
    border: 1px solid #ff5050;
    box-shadow: 0 0 10px #ff5050;
    transition: all 0.3s ease;
  }

  .back-button:hover {
    background-color: rgba(255, 204, 0, 0.51);
    color: #000;
    box-shadow: 0 0 15px #ff0077, 0 0 30px #ff0077;
    transform: scale(1.05);
  }

  .message-box {
    max-width: 420px;
    margin: 20px auto;
    padding: 16px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    box-shadow: 0 0 10px;
  }

  .message-box.success {
    background-color: rgba(0, 255, 136, 0.1);
    border: 2px solid #00ff88;
    color: #00ff88;
    text-shadow: 0 0 5px #00ff88;
    box-shadow: 0 0 12px #00ff88;
  }

  .message-box.error {
    background-color: rgba(255, 80, 80, 0.1);
    border: 2px solid #ff4d4d;
    color: #ff4d4d;
    text-shadow: 0 0 5px #ff4d4d;
    box-shadow: 0 0 12px #ff4d4d;
  }
</style>

<!-- Token Send Form -->
 <h3>LuxCoin Balance: <?= $userTokens ?> </h3><br>
<br>
<form method="post">
  <h2>🎲 Send LuxCoins</h2>

  <label for="receiver_id">User ID to Send To:</label>
  <input type="text" name="receiver_id" id="receiver_id" required placeholder="Enter User ID">

  <label for="token_type">Token Type:</label>
  <select name="token_type" id="token_type" required>
    <option value="NHE">NHE - 30 Tokens (₱99)</option>
    <option value="AU">AU - 2000 Tokens (₱7000)</option>
    <option value="ZNC">ZNC - 777 Tokens (₱2500)</option>
  </select>
  <label for="password">Confirm Your Password:</label>
<input type="password" name="password" id="password" required placeholder="Enter your password">


  <button type="submit">Send LuxCoins</button>
</form>


<!-- Message Box -->
<?php if (!empty($message)): ?>
  <div class="message-box <?= $messageType ?>">
    <?= htmlspecialchars($message) ?>
  </div>
<?php endif; ?>

<a href="index.php" class="back-button">⬅ Back to Main</a>
