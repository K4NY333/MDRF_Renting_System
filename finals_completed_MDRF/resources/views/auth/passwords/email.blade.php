@vite(['resources/css/pass-reset.css'])   

<head>
    <title>Reset Password</title>
</head>

<div class="auth-container">
    <h2>Forgot Your Password?</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="auth-group">
            <label for="email">Email Address:</label>
            <input id="email" type="email" name="email" required placeholder="Enter your Email">
        </div>

        <button type="submit" class="auth-button">Send Password Reset Link</button>
    </form>
    <button type="button" class="auth-button" onclick="window.location='{{ route('homepage.index') }}'">Back to Home</button>
</div>