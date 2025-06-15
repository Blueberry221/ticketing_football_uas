<?php
session_start();

// Ambil session status jika ada
$status = $_SESSION['status'] ?? null;

// Ambil error validasi email jika ada
$errors = $_SESSION['errors']['email'] ?? [];

// Ambil nilai lama dari email jika ada
$oldEmail = $_SESSION['old']['email'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css"> <!-- Tambahkan file CSS jika ada -->
    <style>
        body {
            background-color: #2f4f2f;
            color: #ffff99;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #3b3b3b;
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        .input-field {
            background-color: #808080;
            color: #fff;
            border: none;
            padding: 10px;
            width: 100%;
            margin-top: 8px;
            border-radius: 5px;
        }

        .btn-login {
            background-color: #ffff99;
            color: #2f4f2f;
            border: none;
            padding: 10px 20px;
            margin-top: 15px;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-login:hover {
            background-color: #e6e600;
        }

        .error-message {
            margin-top: 5px;
            color: #ff9999;
            font-size: 0.9em;
        }

        .status-message {
            color: #ccffcc;
            margin-bottom: 15px;
        }

        label {
            margin-top: 10px;
            display: block;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Informasi -->
        <p class="mb-4 text-sm">
            <?= __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') ?>
        </p>

        <!-- Status dari session -->
        <?php if ($status): ?>
            <div class="status-message">
                <?= htmlspecialchars($status) ?>
            </div>
        <?php endif; ?>

        <!-- Formulir -->
        <form method="POST" action="password_email_handler.php">
            <!-- Simulasi CSRF token -->
            <input type="hidden" name="_token" value="<?= csrf_token() ?>">

            <!-- Input Email -->
            <label for="email"><?= __('Email') ?></label>
            <input
                id="email"
                type="email"
                name="email"
                class="input-field"
                value="<?= htmlspecialchars($oldEmail) ?>"
                required
                autofocus
            >

            <!-- Tampilkan error jika ada -->
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <div class="error-message"><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Tombol Submit -->
            <button type="submit" class="btn-login">
                <?= __('Email Password Reset Link') ?>
            </button>
        </form>
    </div>
</body>
</html>
