<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiketing - Football</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #001b36;
            color: #ffff99;
            font-family: Arial, sans-serif;
        }
        .input-field {
            background-color: #808080;
            color: #fff;
            border: none;
            padding: 10px;
            margin: 5px 0;
            width: 100%;
            max-width: 300px;
        }
        .btn-login {
            background-color: #ffff99;
            color: #001b36;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
        }
        .btn-login:hover {
            background-color: #e6e600;
        }
        a {
            color: #ffff99;
            text-decoration: underline;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-4xl font-bold mb-4">Tiketing - Football</h1>
        <p class="mb-6">Hi! Welcome back ☺</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <input type="email" name="email" class="input-field" placeholder="Enter your email" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password" class="input-field" placeholder="Enter your password" required>
            </div>
            <div class="mb-4 flex justify-between items-center max-w-xs mx-auto">
                <label>
                    <input type="checkbox" name="remember" class="mr-2"> Remember Me
                </label>
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
        <p class="mt-4">Not registered yet? Create an account <a href="{{ route('register') }}">Sign Up</a></p>
    </div>
</body>
</html>
