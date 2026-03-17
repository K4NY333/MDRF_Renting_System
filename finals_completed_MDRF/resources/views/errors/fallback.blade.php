<!DOCTYPE html>
<html>
<head>
    <title>Page Not Found</title>
    @vite('resources/css/fallback.css')
</head>
<body>
    <div class="container">
        <div class="content">
            <h1 class="oops-text">Oops!</h1>
            <p class="description">
                Looks like this cozy corner
                of the internet doesn't exist.
            </p>
            <a href="{{ url('/') }}" class="back-button">Back to Home</a>
        </div>
        
        <div class="image-placeholder">
            <img src="{{ asset('assets/mascot-transparent.png') }}" alt="404 Not Found">
        </div>
    </div>
</body>
</html>