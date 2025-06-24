<?php
session_start();

// Give NHE (30 tokens) only if not claimed today
$alreadyClaimed = isset($_SESSION['last_free_nhe_claim']);
$today = date("Y-m-d");

if ($alreadyClaimed && $_SESSION['last_free_nhe_claim'] === $today) {
    $message = "⚠️ You've already claimed your free NHE today. Come back tomorrow!";
    $success = false;
} else {
    // Reward: 1 NHE = 30 LuxCoins
    $_SESSION['tokens'] = isset($_SESSION['tokens']) ? $_SESSION['tokens'] + 30 : 30;
    $_SESSION['last_free_nhe_claim'] = $today;
    $message = "🎉 You've received 1 NHE (30 LuxCoins)!";
    $success = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Free NHE Reward</title>
    <style>
        body {
            background: #111;
            color: #eee;
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 100px;
        }
        .message {
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            margin: auto;
        }
        .success {
            background: #00ff88;
            color: #000;
            box-shadow: 0 0 15px #00ff88;
        }
        .error {
            background: #ff4444;
            box-shadow: 0 0 15px #ff4444;
        }
        .btn {
            padding: 10px 25px;
            background: #ffcc00;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            color: #000;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn:hover {
            background: #ffee00;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="message <?= $success ? 'success' : 'error' ?>">
    <?= $message ?>
</div>

<p>Your Total Tokens: <strong><?= $_SESSION['tokens'] ?? 0 ?></strong></p>
<a href="index.php"><button class="btn">⬅ Back to Game</button></a>

</body>
</html>
