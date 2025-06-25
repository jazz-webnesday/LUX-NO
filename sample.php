<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>LUX!NO Sign In</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    @font-face {
      font-family: "squid";
      src: url('../fonts/Game Of Squids.otf') format('opentype');
    }
    @font-face {
      font-family: "nova";
      src: url('../fonts/SpaceNova-6Rpd1.otf') format('opentype');
    }
    @font-face {
      font-family: "valo";
      src: url('../fonts/Valorax-lg25V.otf') format('opentype');
    }
    @font-face {
      font-family: "big";
      src: url('../fonts/BigSpace-rPKx.ttf') format('truetype');
    }

    * {
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../images/1.png') no-repeat center center fixed;
      background-size: cover;
    }

    .page-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2rem 0;
    }

    .wrapper {
      display: flex;
      width: 90%;
      max-width: 1100px;
      background: #1b0c3d2b;
      border-radius: 15px;
      box-shadow: 0 15px 30px rgba(106, 13, 173, 0.6);
      overflow: hidden;
      font-weight: 500;
      user-select: none;
    }

    .left-side {
      flex: 1;
      background: #390f7334;
      padding: 60px 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-right: 2px solid #6a0dad;
    }

    .welcome-text {
      text-align: center;
    }

    .welcome-text h1 {
      font-size: 3.5rem;
      font-family: "nova";
      margin: 0;
      letter-spacing: 1.5px;
      text-shadow: 0 0 10px #d07aff;
    }

    .welcome-text h4 {
      font-size: 1.4rem;
      font-family: "nova";
      color: #d6a9ffcc;
      margin: 10px 0;
      font-weight: 400;
      letter-spacing: 1px;
    }

    .right-side {
      flex: 1;
      background: #2e1456;
      padding: 60px 30px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .container {
      width: 100%;
      max-width: 400px;
      font-family: 'Times New Roman', Times, serif;
      background: #3e1e83;
      padding: 35px 30px;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(106, 13, 173, 0.8);
      transition: background 0.3s ease;
    }

    .container:hover {
      background: #4b27a7;
    }

    .form-title {
      font-size: 2rem;
      margin-bottom: 30px;
      text-align: center;
      color: #f2e9ff;
      text-shadow: 0 0 6px #a65edc;
    }

    .input-group {
      position: relative;
      margin-bottom: 25px;
    }

    .input-group i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #b49aff;
      font-size: 1.2rem;
    }

    .input-group input {
      width: 100%;
      padding: 12px 15px 12px 45px;
      border: none;
      border-radius: 8px;
      background: #5c3dbb;
      color: #e1d7ff;
      font-size: 1rem;
      box-shadow: inset 0 0 5px #9170d3;
      transition: background 0.3s ease, box-shadow 0.3s ease;
    }

    .input-group input::placeholder {
      color: #d4baffaa;
    }

    .input-group input:focus {
      outline: none;
      background: #6f54d2;
      box-shadow: 0 0 8px #bb9aff;
    }

    .btn {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 8px;
      background: #9b5de5;
      color: #fff;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 6px 15px #bfa2ff;
      transition: background 0.3s ease, box-shadow 0.3s ease;
    }

    .btn:hover {
      background: #a774ff;
      box-shadow: 0 8px 20px #c1a7ff;
    }

    .recover {
      text-align: right;
      margin-top: -15px;
      margin-bottom: 20px;
    }

    .recover a {
      color: #b49aff;
      font-size: 0.9rem;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .recover a:hover {
      color: #e0c2ff;
    }

    @media (max-width: 768px) {
      .wrapper {
        flex-direction: column;
        width: 95%;
      }

      .left-side, .right-side {
        border: none;
        padding: 30px;
      }

      .left-side {
        border-bottom: 2px solid #6a0dad;
      }
    }
  </style>
</head>
<body>

  <div class="page-content">
    <div class="wrapper">
      <div class="left-side">
        <div class="welcome-text">
          <h4>Welcome to</h4>
          <h1>LUXINO</h1>
          <h4>Play Now, Earn Later!</h4>
        </div>
      </div>

      <div class="right-side">
        <div class="container" id="signup" style="display:none;">
      <h1 class="form-title">Register</h1>
      <form method="post" action="register.php">
        <div class="input-group">
           <i class="fas fa-user"></i>
           <input type="text" name="fName" id="fName" placeholder="First Name" required>
           <label for="fname">First Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lName" id="lName" placeholder="Last Name" required>
            <label for="lName">Last Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>
       <input type="submit" class="btn" value="Sign Up" name="signUp">
      </form>
      <p class="or">
        ----------or--------
      </p>
      <div class="icons">
        <i class="fab fa-google"></i>
        <i class="fab fa-facebook"></i>
      </div>
      <div class="links">
        <p>Already Have Account ?</p>
        <button id="signInButton">Sign In</button>
      </div>
    </div>
        <div class="container" id="signIn">
          <h1 class="form-title">Sign In</h1>
          <form method="post" action="register.php">
            <div class="input-group">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <p class="recover">
              <a href="#">Recover Password</a>
            </p>
            <input type="submit" class="btn" value="Sign In" name="signIn">
            <?php if (isset($_SESSION['error'])): ?>
    <div class="auth-message"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="auth-message success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
          </form>

            <p class="or">
          ----------or--------
        </p>
        <div class="icons">
          <i class="fab fa-google"></i>
          <i class="fab fa-facebook"></i>
        </div>
        <div class="links">
          <p>Don't have account yet?</p>
          <button id="signUpButton">Sign Up</button>
        </div>
        </div>

      </div>
    </div>
  </div>

  <?php include 'footer.html'; ?>

</body>
</html>
