<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Confirmation</title>
</head>
<body>
 <h2>Welcome, {{ $name }}!</h2>
    <p>Thank you for registering on our platform.</p>
    <p>Your activation code is: <strong>{{ $activationCode }}</strong></p>
    <p>Please use this code to activate your account.</p>
</body>
</html>
