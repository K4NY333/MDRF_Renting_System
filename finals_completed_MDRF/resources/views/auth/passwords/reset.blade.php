@vite(['resources/css/pass-reset.css'])  

<head>
    <title>Reset Password</title>
</head>

<div class="auth-container">

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="auth-group">
            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $email) }}" required autofocus>
            </div>
        </div>

        <div class="auth-group">
            <div>
                <label>New Password</label>
                <input type="password" name="password" required>
            </div>
        </div>

        <div class="auth-group">
            <div>
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required>
            </div>
        </div>

        <div>
            <button type="submit" class="auth-button">Reset Password</button>
        </div>
    </form>

    <button type="button" class="auth-button" onclick="window.location='{{ url()->previous() }}'">Back</button>

</div>