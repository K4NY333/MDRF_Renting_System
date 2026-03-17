    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MDRF - Apartment Rental For All</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Cozy Font -->
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">

        @vite(['resources/css/style.css', 'resources/css/fiitophone.css', 'resources/js/app.js', 'resources/js/style.js'])
    
        <meta name="csrf-token" content="{{ csrf_token() }}">

    
    </head>
    <body>

        @include('components.hero_section')
        
    <header>    
        <div class="header-content">
            <div class="logo">
                <img src="{{ asset('assets/sample-logo.png') }}" alt="MDRF Logo" class="imglogo">
                <div class="logo-text">
                    <h1>MDRF</h1>
                    <p>APARTMENT RENTAL FOR ALL</p>
                </div>
            </div>  

        <div class="leas" id="ownerBtn" onclick="openOwnerPopup('landowner')">
            <span style="margin-right: 8px;">🔑</span> Leasing
        </div>
            <!-- User Icon triggers popup -->
            <div class="user-icon" id="userProfileBtn" style="cursor:pointer;" onclick="openAuthPopup('login')">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </header>

<!-- Popup Overlay -->
<div class="popup-overlay" id="authPopup" style="display:none;">
  <div class="popup-container">
    <div class="popup-close" id="closeAuthPopup">×</div>

    <div class="auth-tabs">
      <div class="auth-tab active" data-tab="login">Login</div>
      <div class="auth-tab" data-tab="activate">Activate</div>
    </div>

    <div class="auth-form active" id="loginForm">
      @include('auth.login', ['hideBackButton' => true])
    </div>

    <div class="auth-form" id="activateForm">
      @include('activate.account')
    </div>
  </div>
</div>

<div class="popup-overlay" id="ownerPopup" style="display:none;">
    <div class="popup-container">
        <div class="popup-close" id="closeOwnerPopup">×</div>

        <div class="owner-tabs">
          <div class="owner-tab" data-tab="application">Apply as Landowner</div>
        </div>
         <div class="owner-form" id="applicationForm" >
            @include('landowner.application')
        </div>

    </div>
</div>

<!-- Slideshow-->
<div class="carousel-container">
    <div class="carousel" id="room-slideshow">
        <div class="carousel-slide" style="background-image: url('{{ asset('assets/dorm.png') }}');"></div>
        <div class="carousel-slide" style="background-image: url('{{ asset('assets/bedspace.png') }}');"></div>
        <div class="carousel-slide" style="background-image: url('{{ asset('assets/fortwo.jpg') }}');"></div>
        <div class="carousel-slide" style="background-image: url('{{ asset('assets/solo.png') }}');"></div>
    </div>
    <div class="carousel-dots" id="carousel-dots"></div>
</div>


<!-- search bar -->
 <div class="container">
    <form class="search-form" method="GET" action="{{ route('homepage.index') }}#available-section">
        <div class="search-group">
            <i class="fas fa-map-marker-alt"></i>
            <input 
                type="text" 
                name="location" 
                class="form-control" 
                placeholder="Location" 
                value="{{ request('location') }}">
        </div>

        <div class="search-group">
            <i class="fas fa-home"></i>
            <select name="room_type" class="form-select">
                <option value="" {{ request('room_type') }}>Room Type</option>
                <option value="bedspacer" {{ request('room_type') == 'bedspacer' ? 'selected' : '' }}>Bedspacer</option>
                <option value="private" {{ request('room_type') == 'private' ? 'selected' : '' }}>Private</option>
                <option value="shared" {{ request('room_type') == 'shared' ? 'selected' : '' }}>Shared</option>
            </select>
        </div>

        <div class="search-group">
            <i class="fas fa-tag"></i>
            <input 
                type="number" 
                name="min_price" 
                class="form-control" 
                placeholder="Min Price" 
                value="{{ request('min_price') }}">
        </div>

        <div class="search-group">
            <i class="fas fa-tag"></i>
            <input 
                type="number" 
                name="max_price" 
                class="form-control" 
                placeholder="Max Price" 
                value="{{ request('max_price') }}">
        </div>

        <div class="search-group">
            <i class="fas fa-person"></i>
            <input 
                type="number" 
                name="capacity" 
                class="form-control" 
                placeholder="Capacity" 
                value="{{ request('capacity') }}">
        </div>

        <button type="submit" class="search-btn">
            <i class="fas fa-search"></i>
        </button>

        <button type="button" class="search-btn" id="filterBtn">
            <i class="fas fa-bars"></i>
        </button>
  
</div>

<!-- Extra Filters Section -->
<div id="extraFilters" class="container mt-3" style="display: none;">
    <div class="row">
        @php
            $extras = [
                'cctv' => 'CCTV',
                'laundry_area' => 'Laundry Area',
                'has_wifi' => 'Wi-Fi',
                'allowed_pets' => 'Pet Friendly'
            ];
        @endphp

        @foreach ($extras as $field => $label)
            <div class="col-md-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="{{ $field }}" name="{{ $field }}" value="1"
                        {{ request($field) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $field }}">
                        {{ $label }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary">Apply Filters</button>
    </div>
</div>

  </form>

<!-- JavaScript to toggle extra filters -->
<script>
    document.getElementById("filterBtn").addEventListener("click", function () {
        const filters = document.getElementById("extraFilters");
        filters.style.display = (filters.style.display === "none" || filters.style.display === "") ? "block" : "none";
    });
</script>

<!--available -->
 <section id="available-section">
        <div class="available-section">
    <img src="{{ asset('assets/listingBG.jpg') }}" alt="Available Properties" class="available-img">
    <h2 class="available-heading">Available for Rent</h2>
    </div>
<!-- Show available rooms -->
<div class="container">
    <div class="properties-container">
        <div class="properties-slider">
            @forelse($rooms as $room)
                <div class="property-card" data-room-id="{{ $room->id }}" style="cursor:pointer; text-decoration:none;">
                    <!-- <button class="favorite-btn" data-room-id="{{ $room->id }}">
                        <i class="fa-regular fa-heart"></i>
                    </button> -->

                    @if($room->images->first())
                        <img src="{{ asset($room->images->first()->image_path) }}" alt="Room Image" class="property-img">
                    @else
                        <div class="no-image-placeholder property-img" style="height: 270px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #aaa;">
                            No Image
                        </div>
                    @endif

                    <div class="property-info">
                        <h3>{{ ucfirst($room->type) ?? 'Room' }} Room</h3>
<p>{{ $room->place->location ?? 'Unknown location' }}</p>
<p class="property-price">₱{{ number_format($room->price, 2) }} / month</p>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center">No rooms found based on your search.</p>
            @endforelse
        </div>

        <div class="slider-controls">
            <button class="slider-control prev-btn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="slider-control next-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- Room Details -->
<div class="property-details-overlay hidden" id="propertyDetailsPanel">
    <div class="property-details-close" id="closePropertyDetails">×</div>
    <div class="property-details-content" id="propertyDetailsContent">
        <!-- AJAX content will fill this -->
    </div>

    <div class="popup-overlay hidden" id="tryPopup">
        <div class="popup-container">
            <div class="popup-close" id="closeTryPopup">×</div>
            <div class="application-form" id="tryContainer">
                <!-- AJAX-loaded application form goes here -->
            </div>
        </div>
    </div>
</div>
</section>

<script>
    
async function openTryPopup(roomId) {
    
    try {
        const res = await fetch(`/applicant/application/${roomId}`);
        if (!res.ok) throw new Error('Failed to load form.');
        const html = await res.text();
        document.getElementById("tryContainer").innerHTML = html;
        document.getElementById("tryPopup").classList.remove("hidden");
        document.getElementById("tryPopup").classList.add("flex");
    } catch (err) {
        alert("Unable to load application form.");
         console.error(err);
    }
}


document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.property-card').forEach(card => {
        card.addEventListener('click', function (event) {
            // Prevent child buttons (e.g., Apply) from triggering parent
            if (event.target.closest('.property-action-btn')) return;

            const roomId = this.dataset.roomId;

            fetch(`/homepage/${roomId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(room => {
                    let imagesHtml = '';
                    if (room.images.length > 0) {
                        imagesHtml += `<img src="/${room.images[0].image_path}" alt="Main Image" class="property-gallery-main">`;
                        imagesHtml += '<div class="property-thumbs">';
                        room.images.forEach((image, index) => {
                            imagesHtml += `<img src="/${image.image_path}" alt="Thumbnail ${index + 1}" class="property-thumb ${index === 0 ? 'active' : ''}" data-src="/${image.image_path}">`;
                        });
                        imagesHtml += '</div>';
                    }

                    const placeName = room.place ? room.place.name : 'Room';
                    const placeLocation = room.place ? room.place.location : '';

                    const content = `
                        <div class="property-gallery">${imagesHtml}</div>
                        <h2 class="property-title">${placeName}</h2>
                        <div class="property-location"><i class="fas fa-map-marker-alt"></i> ${placeLocation}</div>
                        <div class="property-tags">
                            <div class="property-tag">${room.type} Room</div>
                            <div class="property-tag">${room.capacity} Person(s)</div>
                            <div class="property-tag">₱${parseFloat(room.price).toFixed(2)}</div>
                        </div>
                        <div class="property-price-large">₱${parseFloat(room.price).toFixed(2)} / month</div>
                        <h3 class="property-details-heading">Details</h3>
                        <div class="property-details-list">
                            <div class="property-detail-item"><i class="fas fa-user-friends"></i> Capacity: ${room.capacity}</div>
                            <div class="property-detail-item"><i class="fas fa-building"></i> Type: ${room.type} Room</div>
                            <div class="property-detail-item"><i class="fas fa-map-marker-alt"></i> Location: ${placeLocation}</div>
                            <div class="property-detail-item"><i class="fas fa-info-circle"></i> Status: ${room.status || 'Unknown'}</div>
                            <div class="property-detail-item"><i class="fas fa-utensils"></i> Kitchen Equipment: ${room.kitchen_equipment ? room.kitchen_equipment : 'None'}</div>
                            <div class="property-detail-item"><i class="fas fa-video"></i> CCTV: ${room.cctv ? 'Yes' : 'No'}</div>
                            <div class="property-detail-item"><i class="fas fa-tshirt"></i> Laundry Area: ${room.laundry_area ? 'Yes' : 'No'}</div>
                            <div class="property-detail-item"><i class="fas fa-paw"></i> Pet Friendly: ${room.allowed_pets ? 'Yes' : 'No'}</div>
                            <div class="property-detail-item"><i class="fas fa-wifi"></i> Wi-Fi: ${room.has_wifi ? 'Yes' : 'No'}</div>
                            <div class="property-detail-item"><i class="fas fa-couch"></i> Furniture/Equipment: ${room.furniture_equipment ? room.furniture_equipment : 'None'}</div>
                        </div>
                        <h3 class="property-details-heading">Description</h3>
                        <p class="property-description">${room.place.description || 'No description available.'}</p>
                        <div class="property-action-btns">
                            <div class="property-action-btn property-contact-btn" onclick="openTryPopup(${room.id})">
                                Apply for room
                            </div>
                        </div>
                    `;
                    
                    const panel = document.getElementById('propertyDetailsPanel');
                    document.getElementById('propertyDetailsContent').innerHTML = content;
                    panel.classList.remove("hidden");

                    const mainImg = document.querySelector('.property-gallery-main');
                    const thumbs = document.querySelectorAll('.property-thumb');
                    thumbs.forEach(thumb => {
                        thumb.addEventListener('click', function(e) {
                            e.stopPropagation();
                            // Remove 'active' from all thumbs
                            thumbs.forEach(t => t.classList.remove('active'));
                            // Set clicked thumb as active
                            this.classList.add('active');
                            // Change main image src
                            if (mainImg) {
                                mainImg.src = this.dataset.src;
                            }
                        });
                    });
                })
                .catch(() => alert('Failed to load room details.'));
        });
    });

    document.getElementById("closeTryPopup").addEventListener("click", () => {
        const popup = document.getElementById("tryPopup");
        popup.classList.add("hidden");
        popup.classList.remove("flex");
    });

    document.getElementById('closePropertyDetails').addEventListener('click', function () {
        document.getElementById('propertyDetailsPanel').classList.add('hidden');
    });
});
</script>

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
                        <p>MDRF Compound, Calamba, Laguna, Philippines</p>
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
    </footer>
@if(session('success'))
<script>
    Swal.fire({
        title: 'Welcome Home!',
        text: '{{ session("success") }}',
        icon: 'success',
        background: '#fdf6f0',
        color: '#4b3621',
        iconColor: '#a67c52',
        confirmButtonText: 'Start Exploring',
        confirmButtonColor: '#b07c5b',
        customClass: {
            popup: 'swal-cozy',
            title: 'swal-title',
            confirmButton: 'swal-button',
        },
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        title: 'Oops!',
        text: '{{ session("error") }}',
        icon: 'error',
        background: '#fff3ee',
        color: '#5d3a2a',
        iconColor: '#d07b59',
        confirmButtonText: 'Okay',
        confirmButtonColor: '#d7a184',
        customClass: {
            popup: 'swal-cozy',
            title: 'swal-title',
            confirmButton: 'swal-button',
        },
    });
</script>
@endif
<style>
    .swal-cozy {
        font-family: 'Quicksand', sans-serif;
        border-radius: 1rem;
        box-shadow: 0 8px 24px rgba(112, 88, 68, 0.2);
        padding: 1.5rem;
    }

    .swal-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .swal-button {
        padding: 0.6rem 1.5rem;
        border-radius: 999px;
        font-weight: 600;
        background-color: #b07c5b !important;
        color: #fff !important;
        transition: background-color 0.3s ease;
    }

    .swal-button:hover {
        background-color: #a76e4d !important;
    }
</style>




    </body>
    </html>

