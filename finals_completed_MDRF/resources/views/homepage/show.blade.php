<!-- 


<div class="container py-5">
    <div class="card">
        @if($room->images->first())
            <img src="{{ asset($room->images->first()->image_path) }}" class="card-img-top" style="height: 300px; object-fit: cover;" alt="Room Image">
        @endif

        <div class="card-body">
            <h3>{{ ucfirst($room->type) }} Room</h3>
            <p><strong>Location:</strong> {{ $room->place->location }}</p>
            <p><strong>Capacity:</strong> {{ $room->capacity }}</p>
            <p><strong>Price:</strong> ₱{{ number_format($room->price, 2) }}</p>
            <p><strong>Description:</strong> {{ $room->description ?? 'No description available.' }}</p>
            <a href="{{ route('applicant.application', ['room_id' => $room->id]) }}" class="btn btn-success mt-3">Apply for this Room</a>
        </div>
    </div>
</div> -->

 <!--Room details -->
    <div class="property-details-overlay" id="propertyDetailsPanel">
        <div class="property-details-close" id="closePropertyDetails">×</div>
        <div class="property-details-content">
            <!-- Property Gallery -->
            <div class="property-gallery">
                @if($room->images->first())
                    <img src="{{ asset($room->images->first()->image_path) }}" alt="Property Main Image" class="property-gallery-main" id="propertyMainImage">
                @endif
                <div class="property-thumbs">
                    @foreach($room->images as $index => $image)
                        <img 
                            src="{{ asset($image->image_path) }}" 
                            alt="Property Thumbnail {{ $index + 1 }}" 
                            class="property-thumb {{ $index === 0 ? 'active' : '' }}" 
                            data-src="{{ asset($image->image_path) }}">
                    @endforeach
                </div>
            </div>

            <!-- Title -->
            <h2 class="property-title">{{ ucfirst($room->place->name ?? 'Room') }}</h2>

            <!-- Location -->
            <div class="property-location">
                <i class="fas fa-map-marker-alt"></i>
                <span>{{ $room->place->location }}</span>
            </div>

            <!-- Tags -->
            <div class="property-tags">
                <div class="property-tag">{{ $room->type }} Room</div>
                <div class="property-tag">{{ $room->capacity }} Person(s)</div>
                <div class="property-tag">₱{{ number_format($room->price, 2) }}</div>
            </div>

            <!-- Price -->
            <div class="property-price-large">₱{{ number_format($room->price, 2) }} / month</div>

            <!-- Details -->
            <h3 class="property-details-heading">Details</h3>
            <div class="property-details-list">
                <div class="property-detail-item">
                    <i class="fas fa-user-friends"></i>
                    <span>Capacity: {{ $room->capacity }}</span>
                </div>
                <div class="property-detail-item">
                    <i class="fas fa-building"></i>
                    <span>Type: {{ ucfirst($room->type) }} Room</span>
                </div>
                <div class="property-detail-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Location: {{ $room->place->location }}</span>
                </div>
            </div>

            <!-- Description -->
            <h3 class="property-details-heading">Description</h3>
            <p class="property-description">
                {{ $room->description ?? 'No description available.' }}
            </p>

            <!-- Amenities (if available) -->
            @if($room->amenities && count($room->amenities))
                <h3 class="property-details-heading">Amenities</h3>
                <div class="property-amenities">
                    @foreach($room->amenities as $amenity)
                        <div class="property-amenity">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ $amenity->name }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Action -->
            <div class="property-action-btns">
                <form action="{{ route('applicant.application', ['room_id' => $room->id]) }}" method="GET">
                <button type="submit" class="property-action-btn property-contact-btn">
                Apply for room
                </button>
                </form>
            </div>

        </div>
    </div>
