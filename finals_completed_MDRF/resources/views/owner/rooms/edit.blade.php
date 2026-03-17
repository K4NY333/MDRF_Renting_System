<head>
    <title>Owner | Edit Room</title>
</head>

@vite(['resources/css/owner/rooms/create.css'])

    <h3>Edit Room: {{ $room->name }} ({{ $room->place->name }})</h3>

    <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="place_id" value="{{ $room->place_id }}">

        <div class="mb-3">
            <label for="name" class="form-label">Room Name</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $room->name) }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="type">Room Type</label>
            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                <option value="">-- Select Room Type --</option>
                <option value="bedspacer" {{ old('type', $room->type) == 'bedspacer' ? 'selected' : '' }}>Bedspacer</option>
                <option value="private" {{ old('type', $room->type) == 'private' ? 'selected' : '' }}>Private</option>
                <option value="shared" {{ old('type', $room->type) == 'shared' ? 'selected' : '' }}>Shared</option>
            </select>
            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Room Status</label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="Available" {{ old('status', $room->status) == 'Available' ? 'selected' : '' }}>Available</option>
                <option value="Occupied" {{ old('status', $room->status) == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                <option value="Under Maintenance" {{ old('status', $room->status) == 'Under Maintenance' ? 'selected' : '' }}>Under Maintenance</option>
            </select>
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" name="capacity" id="capacity"
                   class="form-control @error('capacity') is-invalid @enderror"
                   min="1" value="{{ old('capacity', $room->capacity) }}" required>
            @error('capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (₱)</label>
            <input type="number" name="price" id="price"
                   class="form-control @error('price') is-invalid @enderror"
                   step="0.01" value="{{ old('price', $room->price) }}" required>
            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="kitchen_equipment" class="form-label">Kitchen Equipment</label>
            <textarea name="kitchen_equipment" id="kitchen_equipment"
                      class="form-control @error('kitchen_equipment') is-invalid @enderror"
                      rows="2">{{ old('kitchen_equipment', $room->kitchen_equipment) }}</textarea>
            @error('kitchen_equipment') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="hidden" name="cctv" value="0">
            <input type="checkbox" name="cctv" id="cctv" class="form-check-input" value="1"
                   {{ old('cctv', $room->cctv) ? 'checked' : '' }}>
            <label for="cctv" class="form-check-label">Has CCTV</label>
        </div>

        <div class="mb-3 form-check">
            <input type="hidden" name="laundry_area" value="0">
            <input type="checkbox" name="laundry_area" id="laundry_area" class="form-check-input" value="1"
                   {{ old('laundry_area', $room->laundry_area) ? 'checked' : '' }}>
            <label for="laundry_area" class="form-check-label">Has Laundry Area</label>
        </div>

        <div class="mb-3 form-check">
            <input type="hidden" name="allowed_pets" value="0">
            <input type="checkbox" name="allowed_pets" id="allowed_pets" class="form-check-input" value="1"
                   {{ old('allowed_pets', $room->allowed_pets) ? 'checked' : '' }}>
            <label for="allowed_pets" class="form-check-label">Pets Allowed</label>
        </div>

        <div class="mb-3 form-check">
            <input type="hidden" name="has_wifi" value="0">
            <input type="checkbox" name="has_wifi" id="has_wifi" class="form-check-input" value="1"
                   {{ old('has_wifi', $room->has_wifi) ? 'checked' : '' }}>
            <label for="has_wifi" class="form-check-label">Has WiFi</label>
        </div>

        <div class="mb-3">
            <label for="furniture_equipment" class="form-label">Furniture Equipment</label>
            <textarea name="furniture_equipment" id="furniture_equipment"
                      class="form-control @error('furniture_equipment') is-invalid @enderror"
                      rows="2">{{ old('furniture_equipment', $room->furniture_equipment) }}</textarea>
            @error('furniture_equipment') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        @if ($room->images)
            <div>
                <label>Current Images:</label>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    @foreach ($room->images as $image)
                        <div style="position: relative;">
                            <img src="{{ asset($image->image_path) }}" alt="Room Image" style="max-width: 150px;">
                            <label>
                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}">
                                Delete
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif  

        <div class="form-group mb-3">
            <label for="images">Add More Room Images (optional)</label>
            <input type="file" name="images[]" id="images"
                   class="form-control @error('images.*') is-invalid @enderror" multiple>
            @error('images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit">Update Room</button>
        <a href="{{ route('owner', $room->place_id) }}" class="btn btn-secondary">Cancel</a>
    </form>

<style>
button[type="submit"] {
    background: linear-gradient(90deg, #eab566 0%, #8b7355 100%);
    color: #fff;
    border: none;
    border-radius: 18px;
    padding: 0.7rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0.2rem 0.2rem;
    cursor: pointer;
    box-shadow: 0 2px 8px #eab56644;
    transition: background 0.2s, transform 0.2s;
    text-decoration: none;
    display: inline-block;
}

button[type="submit"] {
    background: linear-gradient(90deg, #8b7355 0%, #eab566 100%);
}

button[type="submit"]:hover {
    background: linear-gradient(135deg, #a2854b, #eab566);
}
</style>