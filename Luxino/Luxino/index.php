<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: register.php");
  exit();
}

// Fetch user data from DB
include 'connect.php';
$email = $_SESSION['email'];
$result = $conn->query("SELECT * FROM users WHERE email='$email'");
$user = $result->fetch_assoc();
$username = $user['firstName'];
$lastname = $user['lastName'];
$tokens = $user['tokens'];


/*$rewardMessage = "";

if (isset($_POST['claim_nhe'])) {
    // Simple condition: allow 1 free NHE per session only
    if (!isset($_SESSION['claimed_nhe'])) {
        $nheTokens = 30; // value of 1 NHE
        $conn->query("UPDATE users SET tokens = tokens + $nheTokens WHERE email = '$email'");
        $_SESSION['claimed_nhe'] = true;
        $tokens += $nheTokens;
        $rewardMessage = "🎉 You received 1 Free NHE (30 LuxCoins)!";
    } else {
        $rewardMessage = "⚠️ You've already claimed your free NHE!";
    }
}*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crypto-Casino</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="shortcut icon" href="images/5-removebg-preview.png" type="image/x-icon">
  <style>
        @font-face {
        font-family: "squid";
        src: url('../fonts/Game\ Of\ Squids.otf') format('opentype');
        font-weight: normal; 
        }
        @font-face {
            font-family: "valo";
            src: url(fonts/Valorax-lg25V.otf) format('opentype');
            font-weight: normal;
        }

        .header .right-section {
          display: flex;
          align-items: center;
          gap: 2rem;
        }
        .right-section {
          display: flex;
          align-items: center;
          gap: 2rem;
        }

        .search-container {
          position: relative;
          display: inline-block;
          font-family: "nova";
        }

        #searchInput {
          padding: 10px 12px;
          font-size: 1.75rem;
          font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
          border-radius: 5px;
          border: 1px solid #ccc;
          width: 200px;
        }

        #suggestions {
          position: absolute;
          top: 105%;
          left: 0;
          right: 0;
          font-family: "squid";
          color: #b63b64;
          background: #eee;
          border: 1px solid #ccc;
          border-radius: 0 0 5px 5px;
          max-height: 200px;
          overflow-y: auto;
          z-index: 999;
          display: none;
        }

        #suggestions a {
          display: block;
          padding: 8px 12px;
          text-decoration: none;
          font-size: 12px;
          color: #333;
        }

        #suggestions a:hover {
          background-color: #b63b64;
          color: #ccc;
          padding: 20px;
          font-size: 20px;
        }

        /* NAVBAR FIX */
  
    .header.active {
        background: var(--bg-color);
        box-shadow: var(--box-shadow);
    }


  .header {
    width: 100%;
    background-color:rgba(185, 58, 176, 0.37); /* Full-width background color */
}

.header .flex {
    padding: 0.5rem 1rem; /* Smaller height */
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.95rem;
}



    /* Logo container */
.header .flex .logo {
    display: flex;
    align-items: center;
    font-family: "squid";
    font-size: 3rem;
    background: linear-gradient(90deg,rgb(237, 230, 152),rgb(252, 129, 116)); /* gradient colors */
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
    text-decoration: none;
}


/* Logo image styling */
.header .flex .logo img {
    width: 100px;
    height: 100px;
    margin-right: 0.5rem;
    object-fit: cover;
    transition: 0.3s ease;
}

    .home .flex .image img{
        width: 70%;
        height: 60%;
        text-align: center;
    }


    *{
       
        font-style: normal;
        box-sizing: border-box;
        font-weight: 700;
        outline: none; border: none;
        margin: 0; padding: 0;
        text-decoration: none;
        text-transform: capitalize;
    }    
    
    .navbar {
      display: flex;
      gap: 2rem;
      font-family: "valo", sans-serif;
    }

    .navbar a {
      font-size: 1.5rem;
      color: #fff;
      text-decoration: none;
      padding: 0.5rem 1rem;
      transition: all 0.3s ease;
      border-radius: 8px;
    }

    .navbar a:hover {
      background-color: #b63b64;
      color: #fff;
      box-shadow: 0 0 10px #ff66cc;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-toggle {
      cursor: pointer;
      font-weight: bold;
      padding: 12px 20px;
      font-family: "valo";
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px #b63b64;
      color: #b63b64;
      transition: background 0.3s, color 0.3s;
      font-size: 16px;
    }

    .dropdown-toggle:hover {
      background-color: #b63b64;
      color: #fff;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      right: 0;
      margin-top: 12px;
      background: #fff;
      width: 300px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      border-radius: 12px;
      z-index: 1000;
      padding: 20px;
      box-sizing: border-box;
    }

    .dropdown-menu p {
      margin: 10px 0;
      line-height: 1.4;
      text-align: center;
      color: #333;
    }

    .dropdown-menu p strong {
      display: block;
       font-family:"valo";
      font-size: 30px;
      color: #b63b64;
    }

    .dropdown-menu .tokens {
      font-size: 24px;
      color: #1d3557;
      font-family: "nova";
      font-weight: bold;
    }

    .dropdown-menu .joined {
      font-size: 14px;
      margin-top: 8px;
      color: #777;
    }

    .dropdown-menu a {
      display: block;
      padding: 12px 18px;
      color: #333;
      font-size: 14px;
      text-align: center;
      text-decoration: none;
      border-top: 1px solid #eee;
      border-radius: 6px;
      margin-top: 10px;
      background: #f8f8f8;
      transition: background 0.3s, transform 0.2s;
    }

    .dropdown-menu a:hover {
      background-color: #f0f0f0;
      transform: translateX(4px);
    }

    .show {
      display: block;
        }

        
     .atm{
        display: inline-block;
        font-family: "squid";
        margin-top: 5rem;
        color:rgb(237, 249, 181);
        font-size: 20px;
        border-radius: .7rem;
        font-size: 2.8rem;
        padding: 0.5rem 3rem;
        cursor: pointer;
        background: none;
        transition: .2s linear;
        position: relative;
        z-index: 1;
        overflow: hidden;
        text-align: center;
    }
    .atm strong{
       font-family:"Bebas Neue";
    }


    .atm:hover {
      background-color:rgba(255, 204, 0, 0.01);
      box-shadow:
        0 0 55px #f0f0f0,
        0 0 30px #f0f0f0;
      transform: scale(1.05);
    }
    
    .coin-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr); /* 3 equal columns */
      gap: 0rem; /* spacing between items */
      justify-items: center;
      align-items: center;
      padding: center;
      max-width: 1200px;
      margin: 0 auto;
      min-height: 100vh;

    }

    .coin-option {
      display: inline-block;
      margin:40px;
      padding: 40px;
      text-align: center;
      border-radius: 15px;
      background-color: rgba(51, 9, 31, 0.5);
      box-shadow: 0 0 25px rgb(255, 77, 213);
      color: #fff;
      transition: background 0.3s, color 0.3s;
      cursor: pointer;
      transition: transform 0.2s ease;
    }
    .coin-option:hover {
      transform: scale(1.05);
      background-color:rgb(238, 155, 249);
      color: #fff;
    }
    .coin-option p{
      font-family: "squid", sans-serif;
      font-weight: 400;
      font-style: normal;
      font-size: 1.5rem;
    }  
    .coin-option strong{
      font-family: "squid", sans-serif;
      font-weight: 400;
      font-style: normal;
      font-size: 2rem;
    }
    .coin-option:hover {
      transform: scale(1.05);
      box-shadow: 0 0 25px rgb(230, 113, 251);
    }


    .coin-option img {
      width: 200px;
      height: 200px;
      margin-bottom: 10px;
    }

    .heading {
    text-align: center;
    font-family: "squid", sans-serif;
    color: 0 0 30 rgb(228, 77, 255);
    text-transform: uppercase;
    text-shadow: 0 0 20px #f5a6de;
    text-align: center;
    font-size: 4rem;
    margin-top: 40px;
    margin-bottom: -10rem;
    }
   .heading span {
    color: var(--white);
    font-size: 8rem;
    text-shadow: 0 0 30pxrgb(118, 3, 86);
    }

  </style>
</head>
<body>

<header class="header">
  <section class="flex">
    <a href="#" class="logo">
      <img src="images/5-removebg-preview.png" alt="Logo">
      LUX!NO
    </a>


      <nav class="navbar">
        <a href="#home">Home</a>
        <a href="#game">Games</a>
        <a href="#deals">Deals</a>
        <a href="#contact">Contact</a>

      </nav>


     <!-- RIGHT SECTION -->
    <div class="right-section">
      <!-- SEARCHBAR -->
      <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search games..." oninput="showSuggestions()" />
        <div id="suggestions"></div>
      </div>
  

<script>
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('show');
}
</script>


      <!-- ACCOUNT DROPDOWN -->
      <div class="dropdown">
        <div class="dropdown-toggle" onclick="toggleDropdown()">Account ▼</div>
        <div id="accountDropdown" class="dropdown-menu">
          <p><strong><?= htmlspecialchars($username) . ' ' . htmlspecialchars($lastname); ?></strong></p>
          <p class="user-id">User ID: <?= htmlspecialchars($user['user_id']) ?></p>
          <p class="joined">Joined: <?= date('M. Y', strtotime($user['joined_date'])); ?></p>
          <p class="tokens">Tokens: <?= $tokens; ?></p>
          <a href="buy_tokens.php" class="btn">Buy LuxCoin</a>
          <a href="cashout.php" class="btn">Withdraw</a>
          <a href="send_tokens.php" class="btn">Send LuxCoin</a>
          <a href="transaction_history.php" class="btn">Transaction History</a>
          <a href="logout.php">Sign Out</a>
        </div>
      </div>
    </div>
  </section>
</header>


<!-- header section ends-->


<!-- home section starts -->

<div class="home" id="home">

    <section class="flex">
        <div class="content">
            <h3>HELLO<span> <br><?php echo htmlspecialchars($username); ?>!
            
            </span></h3>
            <a href="#game" class="btn">Play now</a>

           
        </div>
        
        <div class="image">
            <img src="images/Modern_Square_Typographic_Fashion_Brand_Logo__3_-removebg-preview (1).png">
        </div>


    </section>

</div>

<!-- home section ends 
<video width="640" height="360" autoplay loop muted>
    <source src="images/wheel.mp4" type="video/mp4">
    <source src="images/giving (2).mp4" type="video/mp4">
</video>
<video width="640" height="360" autoplay loop muted>
    <source src="images/giving.mp4" type="video/mp4">
</video>-->
<!-- Coin Selection UI -->
 <h1 class="heading" id="deals"><span>LuxCoin</span> Deals</h1> 
<div class="coin-container">
 
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
</div>

<!-- game section starts-->



<div class="games" id="game">
    <h1 class="heading">G<span>AMES</span>

     <br>  <p class="atm">Tokens: <strong><?php echo $tokens; ?></strong></p>
    

    <section class="box-container">
            <div class="box">
        <a href="pakinko.html">
            <img src="images/plinko.png" alt=""/>
        </a>
        </div>

        <div class="box">
        <a href="roulette.html">
            <img src="images/roulette.png" alt=""/>
        </a>
        </div>

        <div class="box">
        <a href="tosscoin.html"> 
            <img src="images/flip coin.png" alt=""/>
        </a>
        </div>

        <div class="box">
        <a href="snake.html"> 
            <img src="images/snake.png" alt=""/>
        </a>
        </div>

        <div class="box">
        <a href="memorygame.html"> 
            <img src="images/memory.png" alt=""/>
        </a>
        </div>

        <form method="post" style="text-align:center; margin-top: 2rem;">
  <button type="submit" name="claim_nhe" class="btn">🎁 Claim Free NHE</button>
</form>

<?php if (!empty($rewardMessage)): ?>
  <div style="text-align:center; margin-top: 10px; color: gold; font-weight: bold; font-size: 1.2rem;">
    <?= $rewardMessage ?>
  </div>
<?php endif; ?>



       
    </section>
</div>


<script>
//SEARCHBAR
  const games = [
    { name: "Plinko", link: "pakinko.html" },
    { name: "Roulette", link: "roulette.html" },
    { name: "Flip Coin", link: "tosscoin.html" },
    { name: "Snake Game", link: "snake.html" },
    { name: "Memory Game", link: "memorygame.html" }
  ];

  function showSuggestions() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const suggestionsBox = document.getElementById("suggestions");

    suggestionsBox.innerHTML = "";
    if (input === "") {
      suggestionsBox.style.display = "none";
      return;
    }

    const filtered = games.filter(game => game.name.toLowerCase().includes(input));

    if (filtered.length > 0) {
      filtered.forEach(game => {
        const link = document.createElement("a");
        link.href = game.link;
        link.textContent = game.name;
        suggestionsBox.appendChild(link);
      });
      suggestionsBox.style.display = "block";
    } else {
      suggestionsBox.style.display = "none";
    }
  }

  // Hide suggestions when clicking outside
  document.addEventListener("click", function (e) {
    const container = document.querySelector(".search-container");
    if (!container.contains(e.target)) {
      document.getElementById("suggestions").style.display = "none";
    }
  });

    //ACCOUNT
function toggleDropdown() {
      document.getElementById("accountDropdown").classList.toggle("show");
    }

    // Close dropdown if clicked outside
    window.onclick = function(event) {
      if (!event.target.closest('.dropdown')) {
        const dropdown = document.getElementById("accountDropdown");
        if (dropdown.classList.contains('show')) {
          dropdown.classList.remove('show');
        }
      }
    }

    function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('show');
}
</script>

<script src="js/script.js"></script>
<?php include 'footer.html'; ?>

</body>
</html>