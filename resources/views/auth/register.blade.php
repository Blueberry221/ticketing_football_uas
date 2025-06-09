<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: /dashboard");
    exit;
}

// Retrieve errors from session if they exist
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']); // Clear errors after retrieval

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['password_confirmation'] ?? '';

    $errors = [];
    if (empty($name)) $errors['name'] = "Name is required.";
    if (empty($email)) $errors['email'] = "Email is required.";
    if (empty($password)) $errors['password'] = "Password is required.";
    if ($password !== $password_confirmation) $errors['password_confirmation'] = "Passwords do not match.";

    if (empty($errors)) {
        // Simulasi proses registrasi (ganti dengan logika sebenarnya)
        $_SESSION['user'] = $name;
        header("Location: /dashboard");
        exit;
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: register.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiketing - Football</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #2f4f2f;
            color: #ffff99;
            font-family: Arial, sans-serif;
        }
        .input-field {
            background-color: #4b5563;
            color: #fff;
            border: 1px solid #4b5563;
            padding: 8px;
            margin: 5px 0;
            width: 100%;
            border-radius: 0.375rem;
        }
        .btn-register {
            background-color: #ffff99;
            color: #052000;
            border: none;
            padding: 8px 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 0.375rem;
        }
        .btn-register:hover {
            background-color: #e6e600;
        }
        a {
            color: #ffff99;
            text-decoration: underline;
        }
        .error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-green-800 p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-4xl font-bold text-yellow-300 text-center mb-6">Tiketing - Football</h1>
        <p class="text-yellow-200 text-center mb-6">Create your account ☺</p>

        <form method="POST" action="register_process.php">
            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-yellow-300">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" class="input-field" required autofocus autocomplete="name">
                <?php if (isset($errors['name'])) echo "<p class='error'>{$errors['name']}</p>"; ?>
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-yellow-300">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" class="input-field" required autocomplete="username">
                <?php if (isset($errors['email'])) echo "<p class='error'>{$errors['email']}</p>"; ?>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-yellow-300">Password</label>
                <input type="password" id="password" name="password" class="input-field" required autocomplete="new-password">
                <?php if (isset($errors['password'])) echo "<p class='error'>{$errors['password']}</p>"; ?>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-yellow-300">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="input-field" required autocomplete="new-password">
                <?php if (isset($errors['password_confirmation'])) echo "<p class='error'>{$errors['password_confirmation']}</p>"; ?>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a href="login" class="underline text-sm text-yellow-200 hover:text-yellow-300">Already registered?</a>
                <button type="submit" class="btn-register ms-4">Register</button>
            </div>
        </form>
    </div>
</body>
</html>
