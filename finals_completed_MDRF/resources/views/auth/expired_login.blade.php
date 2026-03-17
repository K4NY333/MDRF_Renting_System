<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDRF Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #d4c4a0 0%, #b8a582 50%, #a89368 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Background decorative elements */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .session-message {
            color: #8b7355;
            font-size: 16px;
            margin-bottom: 40px;
            text-align: center;
            font-weight: 500;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                0 4px 16px rgba(0, 0, 0, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            width: 100%;
            max-width: 400px;
            position: relative;
            transition: all 0.3s ease;
        }

        .login-title {
            color: #6b4423;
            font-size: 36px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 40px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: -0.5px;
        }

        .auth-group {
            margin-bottom: 25px;
            position: relative;
        }

        .auth-group label {
            display: block;
            color: #6b4423;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .auth-group input {
            width: 100%;
            padding: 18px 20px;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            font-size: 16px;
            color: #5a4632;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .auth-group input::placeholder {
            color: rgba(90, 70, 50, 0.6);
            font-weight: 400;
        }

        .auth-group input:focus {
            background: rgba(255, 255, 255, 0.5);
            border-color: rgba(107, 68, 35, 0.4);
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.05),
                0 0 0 3px rgba(107, 68, 35, 0.1);
            transform: translateY(-2px);
        }

        .auth-button {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #8b5a3c 0%, #6b4423 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 
                0 4px 15px rgba(107, 68, 35, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            margin-top: 15px;
            letter-spacing: 0.5px;
        }

        /* Subtle animations */
        .login-container {
            animation: slideIn 0.6s ease-out;
        }

        .back-button {
            width: 10%;
            padding: 10px;
            background: linear-gradient(135deg, #8b5a3c 0%, #6b4423 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 
                0 4px 15px rgba(107, 68, 35, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            margin-top: 15px;
            letter-spacing: 0.5px;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .login-container {
                margin: 20px;
                padding: 40px 30px;
            }
            
            .login-title {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    
    <div class="session-message">
        @if (session('error'))
            <p>{{ session('error') }}</p>
        @endif
    </div>
    
    <div class="login-container">
        <h1 class="login-title">MDRF Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="auth-group">
                <label for="email">Email Address:</label>
                <input type="email" name="email" id="email" placeholder="Enter your Email Address" required>
            </div>

            <div class="auth-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter your Password" required>
            </div>

            <button type="submit" class="auth-button">Login</button>
        </form>
    </div>

    <button class="back-button" onclick="window.location.href='{{ route('homepage.index') }}'">Back to Home</button>
</body>
</html>