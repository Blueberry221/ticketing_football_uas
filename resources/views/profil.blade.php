<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <style>
        body {
            background-color: #052000;
            font-family: Arial, sans-serif;
            color: #ffff99;
            margin: 0;
            padding: 0;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background-color: #052000;
        }

        nav h2 {
            font-size: 24px;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
        }

        nav ul li {
            display: inline;
        }

        nav ul li a {
            color: #ffff99;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid transparent;
        }

        nav ul li a.active {
            border: 1px solid #ffff99;
        }

        .container {
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

    <nav>
        <h2>Tiketing_Football</h2>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Cart</a></li>
            <li><a href="#">Schedule</a></li>
            <li><a href="#">Tickets</a></li>
            <li><a href="#" class="active">Profile</a></li>
        </ul>
    </nav>

    <div class="container">
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
