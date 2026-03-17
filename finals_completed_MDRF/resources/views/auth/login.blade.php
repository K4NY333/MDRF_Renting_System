<head>
    <title>Login</title>
</head>

<div class="auth-container">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @vite('resources/css/style.css')
        @csrf
        
        <div class="auth-group">
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" placeholder="Enter your Email Address" required>
        </div>

        <div class="auth-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter your Password" required>
        </div>

        <div class="auth-group">
            <a href="{{ route('password.request') }}" class="forgot-password-link">Forgot Password?</a>
        </div>

        <button type="submit" class="auth-button">Login</button>
    </form>
    
    @if (!isset($hideBackButton) || !$hideBackButton)
        <button type="button" class="auth-button" onclick="window.location='{{ route('homepage.index') }}'">Back to Home</button>
    @endif
</div>
   
<style>
    .auth-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 30px;
        border-radius: 10px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }

    .forgot-password-link {
        display: block;
        margin-top: 5px;
        margin-bottom: 15px;
        font-size: 0.9em;
        color: #007BFF;
        text-decoration: none;
    }

    .forgot-password-link:hover {
        text-decoration: underline;
    }

    .alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 10px 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        font-size: 14px;
    }
</style>