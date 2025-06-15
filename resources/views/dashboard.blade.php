<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tiketing Football - Home</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom, #000000, #052000);
      color: #ffffff;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #052000;
      padding: 15px 30px;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #ffff99;
    }

    .menu a {
      color: #ffff99;
      margin-left: 20px;
      text-decoration: none;
      padding: 8px 16px;
      border-radius: 20px;
    }

    .menu a:hover,
    .menu a.active {
      border: 1px solid #ffff99;
      background-color: #002400;
      color: #ffff99;
    }

    .hero {
      width: 100%;
      height: 400px;
      background: url('https://img.freepik.com/free-photo/football-players-action-professional-stadium_654080-1150.jpg') no-repeat center center/cover;
      position: relative;
    }

    .highlight-section {
      background-color: #052000;
      padding: 30px 0;
    }

    .highlight-title {
      color: #ffff99;
      font-size: 24px;
      margin-left: 40px;
      font-weight: bold;
    }

    .highlight-container {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      padding: 20px;
    }

    .arrow {
      font-size: 40px;
      cursor: pointer;
      color: #ffff99;
      user-select: none;
    }

    .highlight-card {
      background-color: #ffff99;
      color: black;
      border-radius: 15px;
      padding: 10px;
      max-width: 250px;
      text-align: left;
    }

    .highlight-card img {
      width: 100%;
      border-radius: 10px;
    }

    .highlight-card p {
      font-size: 14px;
      margin-top: 10px;
    }

    .content {
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <div class="logo">Tiketing_Football</div>
    <div class="menu">
      <a href="index.php" class="active">Home</a>
      <a href="cart.php">Cart</a>
      <a href="schedule.php">Schedule</a>
      <a href="tickets.php">Tickets</a>
      <a href="profile">Profile</a>
    </div>
  </div>

  <div class="hero"></div>

  <div class="highlight-section">
    <div class="highlight-title">HIGHLIGHT</div>
    <div class="highlight-container">
      <div class="arrow"><</div>
      <div class="highlight-card">
        <img src="https://via.placeholder.com/250x150" alt="Transfer News" />
        <p><strong>Bryan Mbeumo</strong> wants to join Manchester United as Ineos prepare talks to sign Brentford star</p>
      </div>
      <div class="highlight-card">
        <img src="https://via.placeholder.com/250x150" alt="Inzaghi News" />
        <p>Not everyone at <strong>Inter</strong> wants Inzaghi to resist Al-Hilal offer</p>
      </div>
      <div class="highlight-card">
        <img src="https://via.placeholder.com/250x150" alt="Preseason News" />
        <p><strong>Premier League</strong> pre-season friendlies 2025/26: Fixtures, results, UK kick-off times</p>
      </div>
      <div class="arrow">></div>
    </div>
  </div>
</body>
</html>
