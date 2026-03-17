<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/loading.css')
</head>
<body>
    <div class="bg-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <div class="loading-container">
        <div class="mascot-container">
            <div class="mascot-placeholder">
                <div class="placeholder-image">
                    <img src="{{ asset('assets/sample-logo.png') }}" alt="Loading Mascot">
                </div>
            </div>
        </div>
        
        <h1 class="loading-text">Loading...</h1>
        <p class="loading-subtitle">MDRF Apartment Rental</p>
        
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>
        
        <div class="loading-dots">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>
</body>
</html>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            const progressBar = document.querySelector('.progress-bar');
            let progress = 0;
            const interval = setInterval(() => {
                if (progress < 100) {
                    progress += 10;
                    progressBar.style.width = progress + '%';
                } else {
                    clearInterval(interval);
                    window.location.href = "{{ $redirectRoute }}";
                }
            }, 200);
        });
</script>