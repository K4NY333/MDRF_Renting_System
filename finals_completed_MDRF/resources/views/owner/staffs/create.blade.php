<head>
    <title>Owner | Add Staff</title>
</head>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Create New Staff Member</h2>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

          <input type="hidden" name="owner_id" value="{{ Auth::id() }}">

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}">
            @error('contact_number') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="service_type" class="form-label">Service Type</label>
            <select name="service_type" class="form-control" required>
                <option value="">-- Select Service --</option>
                <option value="housekeeping">Housekeeping</option>
                <option value="laundry">Laundry</option>
                <option value="electric_maintenance">Electric Maintenance</option>
                <option value="water_maintenance">Water Maintenance</option>
                <option value="repair">Repair</option>
                <option value="security_system_maintenance">Security System Maintenance</option>
                <option value="waste_management">Waste Management</option>
            </select>
            @error('service_type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="image_path" class="form-label">Image (Optional)</label>
            <input type="file" name="image_path" class="form-control">
            @error('image_path') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create Staff</button>
    </form>
</div>
