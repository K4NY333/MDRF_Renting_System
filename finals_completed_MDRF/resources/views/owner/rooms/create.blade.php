<head>
    <title>Owner | Add Room</title>
</head>

@vite(['resources/css/owner/rooms/create.css'])

    <h3>Add Room for: {{ $place->name }}</h3>

    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="place_id" value="{{ $place->id }}">

        <div class="mb-3">
            <label for="name" class="form-label">Room Name</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                required
                value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="type">Room Type</label>
            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                <option value="">-- Select Room Type --</option>
                <option value="bedspacer" {{ old('type') == 'bedspacer' ? 'selected' : '' }}>Bedspacer</option>
                <option value="private" {{ old('type') == 'private' ? 'selected' : '' }}>Private</option>
                <option value="shared" {{ old('type') == 'shared' ? 'selected' : '' }}>Shared</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Room Status</label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
                <option value="Occupied" {{ old('status') == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                <option value="Under Maintenance" {{ old('status') == 'Under Maintenance' ? 'selected' : '' }}>Under Maintenance</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input
                type="number"
                name="capacity"
                id="capacity"
                class="form-control @error('capacity') is-invalid @enderror"
                required
                min="1"
                value="{{ old('capacity') }}"
            >
            @error('capacity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (₱)</label>
            <input
                type="number"
                name="price"
                id="price"
                class="form-control @error('price') is-invalid @enderror"
                required
                step="0.01"
                value="{{ old('price') }}"
            >
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Kitchen Equipment textarea -->
        <div class="mb-3">
            <label for="kitchen_equipment" class="form-label">Kitchen Equipment</label>
            <textarea
                name="kitchen_equipment"
                id="kitchen_equipment"
                class="form-control @error('kitchen_equipment') is-invalid @enderror"
                rows="2">{{ old('kitchen_equipment') }}</textarea>
            @error('kitchen_equipment')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- CCTV checkbox with hidden input to ensure submission -->
        <div class="mb-3 form-check">
            <input type="hidden" name="cctv" value="0">
            <input type="checkbox" name="cctv" id="cctv" class="form-check-input" value="1" {{ old('cctv') ? 'checked' : '' }}>
            <label for="cctv" class="form-check-label">Has CCTV</label>
            @error('cctv')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Laundry Area checkbox -->
        <div class="mb-3 form-check">
            <input type="hidden" name="laundry_area" value="0">
            <input type="checkbox" name="laundry_area" id="laundry_area" class="form-check-input" value="1" {{ old('laundry_area') ? 'checked' : '' }}>
            <label for="laundry_area" class="form-check-label">Has Laundry Area</label>
        </div>

        <!-- Pets Allowed checkbox -->
        <div class="mb-3 form-check">
            <input type="hidden" name="allowed_pets" value="0">
            <input type="checkbox" name="allowed_pets" id="allowed_pets" class="form-check-input" value="1" {{ old('allowed_pets') ? 'checked' : '' }}>
            <label for="allowed_pets" class="form-check-label">Pets Allowed</label>
        </div>

        <!-- WiFi checkbox -->
        <div class="mb-3 form-check">
            <input type="hidden" name="has_wifi" value="0">
            <input type="checkbox" name="has_wifi" id="has_wifi" class="form-check-input" value="1" {{ old('has_wifi') ? 'checked' : '' }}>
            <label for="has_wifi" class="form-check-label">Has WiFi</label>
        </div>

        <!-- Furniture Equipment textarea -->
        <div class="mb-3">
            <label for="furniture_equipment" class="form-label">Furniture Equipment</label>
            <textarea
                name="furniture_equipment"
                id="furniture_equipment"
                class="form-control @error('furniture_equipment') is-invalid @enderror"
                rows="2">{{ old('furniture_equipment') }}</textarea>
            @error('furniture_equipment')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="images">Room Images (you can select multiple)</label>
            <input
                type="file"
                name="images[]"
                id="images"
                class="form-control @error('images.*') is-invalid @enderror"
                multiple
            >
            @error('images.*')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Add Room</button>
        <a href="{{ route('owner', $place->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
