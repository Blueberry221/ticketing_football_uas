<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Ticketing - Register</title>
    <style>
        body {
            background-color: #001b36;
            color: #ffff99;
            font-family: Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            margin: 1rem;
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 0.5rem;
        }

        .input-field {
            background-color: #4b5563;
            color: #ffffff;
            border: 1px solid #4b5563;
            padding: 0.5rem;
            margin-top: 0.25rem;
            width: 100%;
            box-sizing: border-box;
            border-radius: 0.375rem;
            font-size: 1rem;
        }

        .input-field:focus {
            outline: none;
            border-color: #ffff99;
            box-shadow: 0 0 0 2px rgba(255, 255, 153, 0.2);
        }

        .btn-register {
            background-color: #ffff99;
            color: #001b36;
            border: none;
            padding: 0.5rem 1rem;
            margin-top: 1.5rem;
            cursor: pointer;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: background-color 0.2s;
        }

        .btn-register:hover {
            background-color: #e6e600;
        }

        a {
            color: #ffff99;
            text-decoration: underline;
            transition: color 0.2s;
        }

        a:hover {
            color: #e6e600;
        }

        .error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        h1 {
            font-size: 1.875rem;
            font-weight: bold;
            color: #ffff99;
            text-align: center;
            margin-bottom: 1rem;
        }

        p {
            color: #ffffcc;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        label {
            color: #ffff99;
            font-weight: 500;
            display: block;
            margin-bottom: 0.25rem;
        }

        @media (max-width: 640px) {
            .form-container {
                margin: 0.5rem;
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div>
        <h1>Tiketing - Football</h1>
        <p>Create your account ☺</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="input-field" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" aria-describedby="name-error" />
                <x-input-error :messages="$errors->get('name')" class="error" id="name-error" />
            </div>
            <br>

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="input-field" type="email" name="email" :value="old('email')"
                    required autocomplete="username" aria-describedby="email-error" />
                <x-input-error :messages="$errors->get('email')" class="error" id="email-error" />
            </div>
            <br>
            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="input-field" type="password" name="password" required
                    autocomplete="new-password" aria-describedby="password-error" />
                <x-input-error :messages="$errors->get('password')" class="error" id="password-error" />
            </div>
            <br>
            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="input-field" type="password"
                    name="password_confirmation" required autocomplete="new-password"
                    aria-describedby="password_confirmation-error" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="error" id="password_confirmation-error" />
            </div>
            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('login') }}" class="text-sm">
                    {{ __('Already registered?') }}
                </a>
                <x-primary-button class="btn-register">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</body>

</html>
