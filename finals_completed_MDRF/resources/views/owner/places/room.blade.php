<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    @vite(['resources/css/owner/rooms/room.css'])

    <title>Owner | Rooms</title>
</head>


<div class="container my-5 room-details">
    <div class="btn btn-secondary mb-3" onclick="openDashboardPopup('{{ route('places.show') }}')">← Back</div>


<div class="room-layout">
    <div class="image-box">
        @if ($room->images->count())
            <div>
                <!-- Main Image Display -->
                <img id="mainRoomImage" src="{{ asset($room->images[0]->image_path) }}" class="d-block w-100 mb-2" alt="Room Image Main">

                <!-- Thumbnails -->
                <div class="d-flex flex-row gap-2">
                    @foreach ($room->images as $index => $image)
                        <img 
                            src="{{ asset($image->image_path) }}" 
                            class="room-thumb-img" 
                            alt="Room Image Thumbnail {{ $index + 1 }}"
                            style="width: 80px; height: 60px; object-fit: cover; cursor: pointer; border: 2px solid #ddd; border-radius: 4px;"
                            onclick="document.getElementById('mainRoomImage').src='{{ asset($image->image_path) }}'"
                        >
                    @endforeach
                </div>
            </div>
        @else
            <img src="{{ asset('images/default-room.jpg') }}" class="d-block w-100 default-image" alt="Default Room Image">
        @endif
    </div>

        <div class="d-flex mb-3 gap-2">
      <button type="button" class="room-action-btn edit-room-btn" title="Edit Room" onclick="openDashboardPopup('{{ route('rooms.edit', $room->id) }}')">
            <i class="bi bi-pencil-square"></i> Edit
        </button>
        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="room-action-btn delete-room-btn" title="Delete Room" onclick="return confirm('Are you sure you want to delete this room?');">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    </div>

        <div class="card-body info-box">
            <h3 class="card-title">{{ ucfirst($room->name) }} Room</h3>

            <div class="info"><i class="bi bi-house-door"></i> {{ ucfirst($room->type) }} Room</div>
            <div class="info"><i class="bi bi-people"></i> <strong>Capacity:</strong> {{ $room->capacity }} person{{ $room->capacity > 1 ? 's' : '' }}</div>
            <div class="info"><i class="bi bi-cash"></i> <strong>Monthly Rent:</strong> ₱{{ number_format($room->price, 2) }}</div>
            <div class="info"><i class="bi bi-info-circle"></i> <strong>Status:</strong> {{ $room->status }}</div>
            <div class="info"><i class="bi bi-cup-hot"></i> <strong>Kitchen Equipment:</strong> {{ $room->kitchen_equipment ?? 'None' }}</div>
            <div class="info"><i class="bi bi-camera-video"></i> <strong>CCTV:</strong> {{ $room->cctv ? 'Yes' : 'No' }}</div>
            <div class="info"><i class="bi bi-droplet"></i> <strong>Laundry Area:</strong> {{ $room->laundry_area ? 'Yes' : 'No' }}</div>
            <div class="info"><i class="bi bi-hand-thumbs-up"></i><strong>Pet Friendly:</strong> {{ $room->allowed_pets ? 'Yes' : 'No' }}</div>
            <div class="info"><i class="bi bi-wifi"></i> <strong>Wi-Fi:</strong> {{ $room->has_wifi ? 'Yes' : 'No' }}</div>
            <div class="info"><i class="bi bi-display"></i> <strong>Furniture/Equipment:</strong> {{ $room->furniture_equipment ?? 'None' }}</div>
        </div>
    </div>
</div>

   