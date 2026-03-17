<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Tenant Dashboard</title>
    @vite('resources/css/tenant/dashboard.css')   
</head>
<body>

    <header class="header">
        <div class="logo">
            <img src="{{ asset('assets/sample-logo.png') }}" alt="MDRF Logo" class="imglogo">
            <div class="logo-text">
                <h1>MDRF</h1>
                <p>APARTMENT RENTAL FOR ALL</p>
            </div>
        </div>
    </header>

    <div class="main-container">
        <div class="welcome-section">
            <div class="mascot">
                <img src="{{ asset('assets/mascot-transparent.png') }}" alt="Mascot">
            </div>

            <div class="mascot-welcome">
                <div class="welcome-content">
                    <h1 class="welcome-text">Welcome, {{ Auth::user()->name }}!</h1>
                    <div class="action-buttons">
                        <a href="{{ route('tenant.payment') }}" class="btn">PAYMENT</a>
                        <a href="{{ route('maintenance.tenant_requests') }}" class="btn">MAINTENANCE</a>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn">LOG OUT</button>
                        </form>
                    </div>
                </div>

                <div class="avatar">
                    <img src="{{ asset($tenant->image_path) }}" alt="Avatar">
                </div>
            </div>
        </div>

        <div class="lease-section">
            <h3 class="lease-title">Lease Information</h3>  
            Rooms found: {{ $roomTenants->count() }}

            @foreach($roomTenants as $roomTenant)
                @php
                    $room = $roomTenant->room;
                @endphp
                

                <div class="lease-content">
                    <!-- Image and Info Overlay -->
                    <div class="image-container" style="position: relative;">
                        <div class="property-image">
                            @if($room->place && $room->place)
                                <img id="main-image-{{ $roomTenant->id }}" src="{{ asset($room->place->image_path) }}" alt="Place Image">
                            @else
                                <span>No Image</span>
                            @endif
                        </div>
                         <!-- Modal Button -->
                        @if($roomTenant->status === 'renting')
                            <button type="button" class="btn btn-danger" style="margin-top: 10px;" onclick="openTerminationModal({{ $roomTenant->id }})">
                                Request Termination
                            </button>
                            <!-- Modal -->
                            <div id="terminationModal-{{ $roomTenant->id }}" class="modal-terminate" style="display:none; position:fixed; z-index:10000; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); align-items:center; justify-content:center;">
                                <div style="background:#fff; padding:2rem; border-radius:10px; max-width:350px; margin:auto; position:relative;">
                                    <button type="button" onclick="closeTerminationModal({{ $roomTenant->id }})" style="position:absolute; top:10px; right:15px; background:none; border:none; font-size:1.5rem; color:#888;">&times;</button>
                                    <form action="{{ route('tenant.requestTermination', $roomTenant->id) }}" method="POST" onsubmit="return confirm('Do you want to request a lease termination on the selected date?');">
                                        @csrf
                                        <label for="end_date_{{ $roomTenant->id }}">Select End Date:</label>
                                        <input type="date" name="end_date" id="end_date_{{ $roomTenant->id }}" required min="{{ date('Y-m-d') }}" class="input-date" style="margin-bottom:1rem;">
                                        <div style="text-align:right;">
                                            <button type="button" class="btn btn-secondary" onclick="closeTerminationModal({{ $roomTenant->id }})" style="margin-right:8px;">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Okay</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @elseif($roomTenant->status === 'pending_termination')
                            <p class="text-warning mt-2" style="margin-top: 10px;">
                                <strong>Termination request pending approval</strong><br>
                                <small>Requested End Date: {{ \Carbon\Carbon::parse($roomTenant->end_date)->toFormattedDateString() }}</small>
                            </p>
                        @endif
                    </div>
                    <!-- Room Images Thumbnails (separate div) -->
                    <div class="room-thumbnails" style="display: flex; flex-direction: column; align-items: flex-start; margin-left: 24px;">
                        <div class="room-images" style="margin-bottom: 10px;">
                            @forelse ($room->roomImages as $image)
                                <img src="{{ asset($image->image_path) }}" alt="Room Image"
                                     style="cursor:pointer;"
                                     onclick="showMainImage('{{ asset($image->image_path) }}', {{ $roomTenant->id }})">
                            @empty
                                <span>No Room Images</span>
                            @endforelse
                        </div>
                         <!-- Lease Info Overlay -->
                            <div class="lease-info-overlay">
                                <div style="font-size: 1.1rem; font-weight: bold; margin-bottom: 6px;">{{ ucfirst($room->name) }} Room</div>
                                <div style="font-size: 0.95rem;">{{ $room->place->name ?? 'N/A' }}, {{ $room->place->location ?? 'N/A' }}</div>
                                <div style="font-size: 0.95rem;">Type: {{ ucfirst($room->type) }}</div>
                                <div style="font-size: 0.95rem;">Rent: ₱{{ number_format($roomTenant->monthly_rent, 2) }}</div>
                                <div style="font-size: 0.95rem;">Landlord: {{ optional($room->place->owner)->name ?? 'N/A' }} ({{ optional($room->place->owner)->contact_number ?? 'N/A' }})</div>
                            </div>
                    </div>
                </div>
            @endforeach


            </div>

            <div class="carousel-container">
                <div class="carousel" id="room-slideshow">
                    <div class="carousel-slide" style="background-image: url('{{ asset('assets/wctenant.png') }}');"></div>
                </div>
                <div class="carousel-dots" id="carousel-dots"></div>
            </div>

        </div>
        
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <h2>MDRF</h2>
                    <p>Apartment Rentals</p>
                </div>
                    
                <div class="footer-contact">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Calamba, Laguna, Philippines</p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <p>0999-999-9999</p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <p>mdrf1234@gmail.com</p>
                    </div>
                </div>
                    
                <div class="footer-links">
                    <h3>Support</h3>
                    <ul>
                        <li>Terms and Conditions</li>
                        <li>Privacy Policy</li>
                    </ul>
                </div>
                    
                <div class="footer-links">
                    <h3>Developers</h3>
                    <ul>
                        <li>Daniel Rojas</li>
                        <li>Francis Saragoza</li>
                        <li>Rianne Gonzales</li>
                        <li>Ranzes Madera</li>
                    </ul>
                </div>
                    
                <div class="social-links">
                    <div class="social-link">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                    <div class="social-link">
                        <i class="fab fa-facebook-messenger"></i>
                    </div>
                    <div class="social-link">
                        <i class="fab fa-instagram"></i>
                    </div>
                </div>
            </div>
                
            <div class="copyright">
                <p>© 2025 MDRF. All rights reserved.</p>
            </div>
        </div>
                <script>
function openTerminationModal(id) {
    document.getElementById('terminationModal-' + id).style.display = 'flex';
}
function closeTerminationModal(id) {
    document.getElementById('terminationModal-' + id).style.display = 'none';
}

function showMainImage(src, id) {
    const mainImg = document.getElementById('main-image-' + id);
    if(mainImg) mainImg.src = src;
}
</script>
    </footer>

    <script>
    const carousel = document.querySelector(".carousel");
    const dots = document.querySelectorAll(".dot");
    let currentSlide = 0;

    function showSlide(index) {
        carousel.style.transform = `translateX(-${index * 100}%)`;

        dots.forEach((dot) => dot.classList.remove("active"));
        dots[index].classList.add("active");

        currentSlide = index;
    }

    dots.forEach((dot) => {
        dot.addEventListener("click", function () {
            showSlide(parseInt(this.getAttribute("data-index")));
        });
    });

    // slide show
    document.addEventListener("DOMContentLoaded", () => {
        const slides = document.querySelectorAll(".carousel-slide");
        const dotsContainer = document.querySelector(".carousel-dots");
        const carousel = document.querySelector(".carousel");
        let currentIndex = 0;

        slides.forEach((_, index) => {
            const dot = document.createElement("div");
            dot.classList.add("dot");
            if (index === 0) dot.classList.add("active");
            dot.addEventListener("click", () => {
                moveToSlide(index);
            });
            dotsContainer.appendChild(dot);
        });

        function moveToSlide(index) {
            carousel.style.transform = `translateX(-${index * 100}%)`;
            document
                .querySelectorAll(".dot")
                .forEach((dot) => dot.classList.remove("active"));
            document.querySelectorAll(".dot")[index].classList.add("active");
            currentIndex = index;
        }

        function autoSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            moveToSlide(currentIndex);
        }

        setInterval(autoSlide, 4000);


});
</body>
</html>