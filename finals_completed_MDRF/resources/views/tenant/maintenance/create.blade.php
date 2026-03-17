<div class="container">
    <h2>Submit Maintenance Request</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('maintenance.store') }}">
        @csrf

        <div class="mb-3">
            <label for="room_id" class="form-label">Select Room</label>
            <select name="room_id" id="room_id" class="form-control" required>
                <option value="">-- Select Room --</option>
                @foreach ($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->name }} ({{ $room->place->name }})</option>
                @endforeach
            </select>
            @error('room_id')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- NEW: Service Type Field --}}
        <div class="mb-3">
            <label for="service_type_id" class="form-label">Select Service Type</label>
            <select name="service_type_id" id="service_type_id" class="form-control" required>
                <option value="">-- Select Service Type --</option>
                @foreach ($serviceTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @error('service_type_id')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
            @error('description')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit Request</button>
    </form>
</div>
