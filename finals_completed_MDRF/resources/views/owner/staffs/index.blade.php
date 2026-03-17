@vite(['resources/css/owner/staff.css']) 

<head>
    <title>Owner | Staff Dashboard</title>
</head>

<div class="container">
    <div class="mb-4">
        <h2>Staff Dashboard</h2>

        
           <div onclick="openDashboardPopup('{{ route('staff.create') }}')" class="btn btn-primary">+ Create Staff</div>
</div>

@if($staffMembers->isEmpty())
    <div class="alert alert-info">No staff members found.</div>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Service Type</th>
                <th>Contact</th>
                <th>Imployer</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staffMembers as $staff)
                <tr>
                    <td>{{ $staff->name }}</td>
                    <td>{{ $staff->email }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $staff->service_type)) }}</td>
                    <td>{{ $staff->contact_number ?? 'N/A' }}</td>
                    <td>{{ $staff->owner->name ?? 'Unassigned' }}</td>
                    <td>
                        @if($staff->image_path)
                           <img src="{{ asset($staff->image_path) }}" width="150" />

                        @else
                            <span>No image</span>
                        @endif
                    </td>
                    <td>
                      <button class="btn btn-sm btn-warning" title="Edit" style="margin-right: 5px;"
                        onclick="openDashboardPopup('{{ route('staff.edit', $staff->id) }}')">
                        <i class="bi bi-pencil-square"></i>
                      </button>
                        <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this staff member?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
</div>

