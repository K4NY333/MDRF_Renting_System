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
                419 Page Expired. It seems like your session has timed out.
            </p>
            <a href="{{ url('/') }}" class="back-button">Back to Home</a>
        </div>
        
        <div class="image-placeholder">
            <img src="{{ asset('assets/mascot-transparent.png') }}" alt="419 Page Expired">
        </div>
    </div>
</body>
</html>