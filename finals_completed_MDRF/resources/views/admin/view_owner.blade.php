@vite(['resources/css/admin.css'])
<!-- Owner Profile -->
<div class="owner-profile">
    <h1 class="property-title">{{ $owner->name }}</h1>
    <p class="property-location"><i class="fas fa-envelope"></i> {{ $owner->email }}</p>
    <p class="property-location"><i class="fas fa-phone"></i> {{ $owner->phone }}</p>
</div>

@if ($owner->places->count())
    @foreach ($owner->places as $place)
        <!-- Place Card -->
        <div class="place-card">
            <img src="{{ asset($place->image_path) }}" class="place-img" alt="Place Image">
            <div class="place-info">
                <h2>{{ $place->title }}</h2>
                <p><i class="fas fa-map-marker-alt"></i> {{ $place->location }}</p>
                <p>{{ $place->description }}</p>
            </div>
        </div>

        <!-- Rooms under this Place -->
        @if ($place->rooms->count())
            <div class="properties-container">
                <h3 class="property-details-heading">Rooms in {{ $place->title }}</h3>

                <div class="properties-slider" id="slider-{{ $place->id }}">
                    @foreach ($place->rooms as $room)
                        <div class="property-card" onclick="openRoomPanel({{ $room->id }})">
                            <button class="favorite-btn"><i class="far fa-heart"></i></button>

                            @if ($room->images->count())
                                <img src="{{ asset($room->images->first()->image_path) }}" class="scroll-image" alt="Room Image">
                            @else
                                <img src="{{ asset('/images/default-room.jpg') }}" class="scroll-image" alt="Default Room Image">
                            @endif
                           
                            <div class="property-info">
                                <h3>{{ $room->name }}</h3>
                                <p>{{ $room->type }}</p>
                                <p class="property-price">₱{{ number_format($room->price, 2) }}</p>
                            </div>
                        </div>

                        <!-- Room Details Panel -->
                        <div class="property-details-overlay" id="room-panel-{{ $room->id }}">
                            <div class="property-details-close" onclick="closeRoomPanel({{ $room->id }})">×</div>
                            <div class="property-details-content">
                                <div class="property-gallery">
                                    @if ($room->images && $room->images->count() > 0)
                                        <div class="property-thumbs">
                                            @foreach ($room->images as $img)
                                                <img src="{{ asset($img->image_path) }}" class="property-thumb" alt="Room Image" onclick="setMainImage(this, {{ $room->id }})">
                                            @endforeach
                                        </div>
                                        <img src="{{ asset($room->images->first()->image_path) }}" class="property-gallery-main" id="main-image-{{ $room->id }}" alt="Room Image">
                                    @else
                                        <img src="{{ asset('/images/default-room.jpg') }}" class="property-gallery-main" alt="Room Image">
                                        <p class="text-muted">No additional room images available.</p>
                                    @endif
                                </div>

                                <h2 class="property-title">{{ $room->name }}</h2>
                                <p class="property-location"><i class="fas fa-map-marker-alt"></i> {{ $place->location }}</p>
                                <p class="property-price-large">₱{{ number_format($room->price, 2) }}</p>

                                <h3 class="property-details-heading">Room Details</h3>
                                <div class="property-details-list">
                                    <div class="property-detail-item"><i class="fas fa-door-closed"></i> Type: {{ $room->type }}</div>
                                    <div class="property-detail-item"><i class="fas fa-users"></i> Capacity: {{ $room->capacity }}</div>
                                    <div class="property-detail-item"><i class="fas fa-check-circle"></i> Status: {{ $room->status }}</div>
                                </div>

                                <p class="property-description">{{ $room->description }}</p>

                                <div class="property-action-btns">
                                    <button class="property-view-btn">View Availability</button>
                                    <button class="property-contact-btn">Contact Owner</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Slider Controls -->
                <div class="slider-controls">
                    <button class="slider-control" onclick="scrollSlider('slider-{{ $place->id }}', -1)">‹</button>
                    <button class="slider-control" onclick="scrollSlider('slider-{{ $place->id }}', 1)">›</button>
                </div>
            </div>
        @else
            <p>No rooms listed under this place yet.</p>
        @endif
    @endforeach
@else
    <p>This owner has no listed places or rooms.</p>
@endif

<!-- JavaScript Functions -->
<script>
   // Open Room Details Panel
function openRoomPanel(roomId) {
    const panel = document.getElementById(`room-panel-${roomId}`);
    if (panel) {
        panel.classList.add('active');
    }
}

// Close Room Details Panel
function closeRoomPanel(roomId) {
    const panel = document.getElementById(`room-panel-${roomId}`);
    if (panel) {
        panel.classList.remove('active');
    }
}

// Switch main gallery image when clicking thumbnails
function setMainImage(imgElement, roomId) {
    const mainImage = document.getElementById(`main-image-${roomId}`);
    if (mainImage && imgElement) {
        mainImage.src = imgElement.src;

        // Remove active class from all siblings
        const thumbs = imgElement.parentElement.querySelectorAll('.property-thumb');
        thumbs.forEach(t => t.classList.remove('active'));
        // Add active class to clicked thumbnail
        imgElement.classList.add('active');
    }
}

// Slider scroll left/right
function scrollSlider(sliderId, direction) {
    const slider = document.getElementById(sliderId);
    if (slider) {
        const scrollAmount = 300; // px amount to scroll
        slider.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    }
}

</script>

<style>
/* Owner Profile */
.owner-profile {
    margin-bottom: 30px;
}

/* Place Card */
.place-card {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 12px rgba(0,0,0,0.08);
    overflow: hidden;
    cursor: default;
}

.place-img {
    width: 200px;
    height: 140px;
    object-fit: cover;
}

.place-info {
    padding: 15px;
    flex-grow: 1;
}

.place-info h2 {
    font-size: 22px;
    margin-bottom: 6px;
    color: #5d4a38;
}

.place-info p {
    margin: 5px 0;
    color: #666;
}

/* Properties Container */
.properties-container {
    margin-bottom: 40px;
}

/* Properties Slider */
.properties-slider {
    display: flex;
    overflow-x: auto;
    gap: 15px;
    scroll-behavior: smooth;
    padding-bottom: 10px;
}

/* Property Card */
.property-card {
    min-width: 250px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    cursor: pointer;
    position: relative;
    transition: transform 0.3s ease;
}

.property-card:hover {
    transform: scale(1.03);
}

.property-card img.scroll-image {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-radius: 10px 10px 0 0;
}

.property-info {
    padding: 15px;
}

.property-info h3 {
    margin-bottom: 5px;
    color: #5d4a38;
}

.property-info p {
    margin: 3px 0;
    color: #666;
}

.property-price {
    font-weight: 600;
    color: #5d4a38;
}

/* Favorite button on property card */
.favorite-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: transparent;
    border: none;
    font-size: 18px;
    color: #b89b7a;
    cursor: pointer;
    z-index: 10;
}

/* Property Details Overlay (Room Details) */
.property-details-overlay {
    position: fixed;
    top: 0;
    right: 0;
    width: 0;
    height: 100%;
    background-color: white;
    box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
    z-index: 999;
    overflow-y: auto;
    transition: width 0.3s ease;
    opacity: 0;
    pointer-events: none;
}

.property-details-overlay.active {
    width: 40%;
    opacity: 1;
    pointer-events: auto;
}

.property-details-close {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 30px;
    cursor: pointer;
    color: #888;
}

.property-details-content {
    padding: 30px;
}

.property-gallery {
    margin-bottom: 20px;
}

.property-gallery-main {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 10px;
}

.property-thumbs {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding-bottom: 10px;
}

.property-thumb {
    width: 70px;
    height: 50px;
    object-fit: cover;
    border-radius: 5px;
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.3s ease;
    border: 2px solid transparent;
}

.property-thumb:hover,
.property-thumb.active {
    opacity: 1;
    border-color: #b89b7a;
}

.property-title {
    font-size: 28px;
    font-weight: 600;
    color: #5d4a38;
    margin-bottom: 10px;
}

.property-location {
    display: flex;
    align-items: center;
    color: #666;
    margin-bottom: 15px;
}

.property-location i {
    margin-right: 8px;
    color: #b89b7a;
}

.property-price-large {
    font-size: 24px;
    font-weight: 600;
    color: #5d4a38;
    margin-bottom: 20px;
}

.property-details-heading {
    font-size: 20px;
    font-weight: 600;
    margin: 20px 0 10px;
    color: #5d4a38;
}

.property-details-list {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 20px;
}

.property-detail-item {
    display: flex;
    align-items: center;
}

.property-detail-item i {
    margin-right: 10px;
    color: #b89b7a;
    width: 20px;
    text-align: center;
}

.property-description {
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
}

.property-action-btns {
    display: flex;
    gap: 10px;
    margin-top: 30px;
}

.property-view-btn {
    flex: 1;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    font-weight: 500;
    cursor: pointer;
    background-color: #f1f1f1;
    color: #333;
}

.property-contact-btn {
    flex: 1;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    font-weight: 500;
    cursor: pointer;
    background-color: #5d4a38;
    color: white;
}

/* Slider Controls */
.slider-controls {
    text-align: center;
    margin-top: 10px;
}

.slider-control {
    cursor: pointer;
    font-size: 28px;
    border: none;
    background: transparent;
    color: #5d4a38;
    margin: 0 10px;
    transition: color 0.3s ease;
}

.slider-control:hover {
    color: #b89b7a;
}

</style>
