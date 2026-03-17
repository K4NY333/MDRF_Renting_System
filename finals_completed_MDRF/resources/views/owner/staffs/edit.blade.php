<head>
    <title>Owner | Edit Staff</title>
</head>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Staff Member</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $staff->name) }}">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email', $staff->email) }}">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $staff->contact_number) }}">
            @error('contact_number') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Service Type</label>
            <select name="service_type" class="form-control" required>
                <option value="">-- Select Service --</option>
                @foreach(['housekeeping','laundry','electric_maintenance','water_maintenance','repair','security_system_maintenance','waste_management'] as $type)
                    <option value="{{ $type }}" {{ old('service_type', $staff->service_type) == $type ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $type)) }}
                    </option>
                @endforeach
            </select>
            @error('service_type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            @if($staff->image_path)
                <img src="{{ asset($staff->image_path) }}" alt="Staff Image" width="150" class="mb-2">
            @else
                <p>No image uploaded.</p>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Change Image (Optional)</label>
            <input type="file" name="image_path" class="form-control">
            @error('image_path') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Staff</button>
    </form>
</div>
