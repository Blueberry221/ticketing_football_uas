<!-- resources/views/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In / Up</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>
  <div class="container" id="container">
    <div class="form-container sign-up-container">
      <form action="{{ route('register') }}" method="POST">
        @csrf
        <h1>Create Account</h1>
        <input type="text" name="name" placeholder="Name" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required />
        <button type="submit">Sign Up</button>
      </form>
    </div>
    <div class="form-container sign-in-container">
      <form action="{{ route('login') }}" method="POST">
        @csrf
        <h1>Sign in</h1>
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Sign In</button>
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Welcome Back!</h1>
          <p>To keep connected with us please login with your personal info</p>
          <button class="ghost" id="signIn">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>Hello, Friend!</h1>
          <p>Enter your personal details and start journey with us</p>
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
