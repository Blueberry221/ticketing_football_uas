<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tiketing Football - Profile</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #052000;
            color: #ffffff;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #000000;
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

        .content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 30px;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #ffff99;
            object-fit: cover;
        }

        .change-picture {
            margin-top: 10px;
            font-size: 14px;
            color: #ffff99;
        }

        .form-group {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            width: 300px;
        }

        .form-group label {
            margin-bottom: 5px;
        }

        .form-group input {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ffff99;
            background-color: #002400;
            color: #ffff99;
        }

        .update-button {
            margin-top: 30px;
            padding: 10px;
            width: 300px;
            background-color: #002400;
            color: #ffff99;
            border: 1px solid #ffff99;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .update-button:hover {
            background-color: #013b01;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="logo">Tiketing_Football</div>
        <div class="menu">
            <a href="dashboard">Home</a>
            <a href="cart.php">Cart</a>
            <a href="schedule.php">Schedule</a>
            <a href="tickets.php">Tickets</a>
            <a href="profile" class="active">Profile</a>
        </div>
    </div>

    <div class="content">
        <img src="https://i.imgur.com/4M34hi2.png" alt="Profile Picture" class="profile-picture">
        <div class="change-picture">Change Picture</div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" value="bani jameszs">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" value="Tonimas@gmail.com">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" value="12345678">
        </div>

        <button class="update-button">Update</button>
    </div>
</body>

</html>
