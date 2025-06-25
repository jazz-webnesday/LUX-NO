<?php
session_start();
include 'connect.php';

// === SIGN UP ===
if (isset($_POST['signUp'])) {
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // You can replace with password_hash() later

    // Generate user_id
    $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $user_id = substr(str_shuffle($letters), 0, 3) . substr(str_shuffle($numbers), 0, 9);

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "❌ Email address already exists!";
        header("Location: signup.php");
        exit();
    } else {
        $insertQuery = $conn->prepare("INSERT INTO users (user_id, firstName, lastName, email, password) VALUES (?, ?, ?, ?, ?)");
        $insertQuery->bind_param("sssss", $user_id, $firstName, $lastName, $email, $password);

        if ($insertQuery->execute()) {
            $_SESSION['success'] = "✅ Registration successful! Please log in.";
            header("Location: signup.php");
            exit();
        } else {
            $_SESSION['error'] = "❌ Error: " . $conn->error;
            header("Location: signup.php");
            exit();
        }
    }
}

// === SIGN IN ===
if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $sql->bind_param("ss", $email, $password);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = '❌ Incorrect email or password';
        header("Location: signup.php");  // ✅ redirect back to signup.php
        exit();
    }
}

?>

