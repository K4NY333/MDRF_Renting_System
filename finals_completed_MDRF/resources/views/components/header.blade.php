<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDRF | Apartment Rental</title>
</head>
<body>

    <header>    
        <div class="header-content">
            <div class="logo">
                <img src="{{ asset('assets/sample-logo.png') }}" alt="MDRF Logo" class="imglogo">
                <div class="logo-text">
                    <h1>MDRF</h1>
                    <p>APARTMENT RENTAL FOR ALL</p>
                </div>
            </div>  

            <div class="leas">
    <a href="{{ route('landowner.application') }}" style="color: white; text-decoration: none;">Leasing</a>
</div>


            <!-- User Icon -->
            <div class="user-icon" id="userProfileBtn">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </header>

    {{ $slot }}
</body>
</html>
