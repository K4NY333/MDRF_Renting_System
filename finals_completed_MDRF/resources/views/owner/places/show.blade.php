@vite(['resources/css/owner/places/show.css'])

    @foreach ($places as $place)
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title mb-3">{{ $place->name }}</h2>

                    @if ($place->image_path)
                        <div class="image-container position-relative mb-3">
                            <!-- Button Positioned Over Image -->
                            <div class="edit-button-overlay" style="display: flex; gap: 8px;">
                                <div class="edit-BTTONN" onclick="openDashboardPopup('{{ route('places.edit',  $place->id) }}')" title="Edit Place">
                                    <i class="bi bi-pencil-square"></i>
                                </div>
                                <form action="{{ route('owner_places.destroy', $place->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this place?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-BTTONN" title="Delete Place">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Image -->
                            <img src="{{ asset($place->image_path) }}" alt="{{ $place->name }} Image" class="img-fluid rounded">
                        </div>
                    @else
                        <p class="text-muted mb-3">This place has no image uploaded.</p>
                    @endif

                <div class="property-info">
                    <p class="mb-2"><strong>Location:</strong> {{ $place->location }}</p>
                    <p class="mb-2"><strong>Property Type:</strong> {{ ucfirst($place->type) }}</p>
                    <p class="mb-2"><strong>Description:</strong> {{ $place->description ?? 'No description available.' }}</p>
                </div>

                <h4>Room Listings</h4>
                @if ($place->rooms && $place->rooms->count())
                    <div class="room-scroll-wrapper position-relative d-flex align-items-center">
                        <button
                            class="carousel-btn left"
                            onclick="scrollRooms({{ $place->id }}, 'left')"
                            aria-label="Scroll rooms left"
                            type="button"
                        >&#8249;</button> 

                        <div id="roomScroll{{ $place->id }}" class="room-scroll flex-grow-1" tabindex="0" aria-live="polite">
                            @foreach ($place->rooms as $room)
                                @php
                                    $roomType = ucfirst($room->type);
                                    $backgroundImage = $room->images->count() ? asset($room->images->first()->image_path) : '';
                                @endphp

                                <div class="card shadow-sm room-card"
                                    style="background-image: url('{{ $backgroundImage }}');"
                                    role="button"
                                    tabindex="0"
                                    aria-label="{{ $roomType }} Room, Room Number {{ $room->room_number }}, Capacity {{ $room->capacity }} person{{ $room->capacity > 1 ? 's' : '' }}, Monthly Rent ₱{{ number_format($room->price, 2) }}"
                                    
                                    onclick="openDashboardPopup('{{ route('rooms.show', $room->id) }}')"
                                    >
                                    
                                    @if ($room->images->count())
                                        <img
                                            src="{{ asset($room->images->first()->image_path) }}"
                                            class="card-img-top"
                                            alt="{{ $roomType }} Room Image"
                                        >
                                    @endif

                                    <div class="card-body">
                                        <h5 class="card-title">{{ $roomType }} Room</h5>
                                        <p class="mb-1"><strong>Room #:</strong> {{ $room->name }}</p>
                                        <p class="mb-1"><strong>Capacity:</strong> {{ $room->capacity }} person{{ $room->capacity > 1 ? 's' : '' }}</p>
                                        <p><strong>Monthly Rent:</strong> ₱{{ number_format($room->price, 2) }}</p>
                                    </div>
                                </div>
                                </a>
                            @endforeach
                        </div>

                        <button
                            class="carousel-btn right"
                            onclick="scrollRooms({{ $place->id }}, 'right')"
                            aria-label="Scroll rooms right"
                            type="button"
                        >&#8250;</button>
                    </div>
                @else
                    <p class="text-muted">No rooms have been added for this place yet.</p>
                @endif
            </div>
            <div class="BTTON">
                <div class="BTTONN" onclick="openDashboardPopup('{{ route('rooms.create', ['place_id' => $place->id]) }}')">
                    + Add Room
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Room Details Modal -->
<div id="roomDetailsModal" class="modal" style="display:none;">
  <div class="modal-content">
    <button id="closeModalBtn" class="close-btn">&times;</button>
    <h2 id="roomType"></h2>
    <p><strong>Number:</strong> <span id="roomNumber"></span></p>
    <p><strong>Capacity:</strong> <span id="roomCapacity"></span></p>
    <p><strong>Price:</strong> <span id="roomPrice"></span></p>
    <p id="roomDescription"></p>

    <!-- Scrollable image wrapper -->
    <div id="roomImage" class="scrollable-image-container"></div>
  </div>
</div>
