@vite(['resources/css/owner/maintenance/request.css'])

<head>
    <title>Owner | Service Requests</title>
</head>

<div>
    <h2 class="mb-4">Service Requests</h2>

    <!-- Navigation Tabs -->
    <div class="tab-row" id="requestTabs" role="tablist">
        @foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $status => $label)
            <div class="tab-row-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                        id="{{ $status }}-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#{{ $status }}"
                        type="button"
                        role="tab"
                        aria-controls="{{ $status }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    {{ $label }}
                </button>
            </div>
        @endforeach
    </div>

    <!-- Tab Contents -->
    <div class="tab-content mt-3" id="requestTabsContent">
        @foreach (['pending', 'approved', 'rejected'] as $status)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                 id="{{ $status }}"
                 role="tabpanel"
                 aria-labelledby="{{ $status }}-tab">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Room Number</th>
                            <th>Description</th>
                            <th>Service Type</th>
                            <th>Status</th>
                            @if ($status === 'pending' || $status === 'approved')
                                <th>Assigned Staff</th>
                            @endif
                            @if ($status === 'pending')
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests->where('status', $status) as $request)
                            <tr>
                                <td>{{ $request->room->id ?? 'N/A' }}</td>
                                <td>{{ $request->description }}</td>
                                <td>{{ $request->service_type }}</td>
                                <td>
                                    <span class="badge
                                        @if ($status === 'pending') bg-warning text-dark
                                        @elseif ($status === 'approved') bg-success
                                        @elseif ($status === 'rejected') bg-danger
                                        @endif">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>

                                @if ($status === 'pending')
                                    <td>
                                        <!-- Assign Staff Form -->
                                        <form action="{{ route('maintenance.assign', $request->id) }}" method="POST">
                                            @csrf
                                            <select name="staff_id"
                                                    class="form-select form-select-sm"
                                                    onchange="this.form.submit();"
                                                    required>
                                                <option value="">Assign Staff</option>
                                                @foreach($staffGrouped[$request->service_type] ?? [] as $staff)
                                                    <option value="{{ $staff->id }}"
                                                        {{ $request->staff_id == $staff->id ? 'selected' : '' }}>
                                                        {{ $staff->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                        {{ $request->staff->name ?? 'Not Assigned' }}
                                    </td>
                                @endif
                
                                    @if ( $status === 'approved')
                                    <td>
                                        {{ $request->staff->name ?? 'Not Assigned' }}
                                    </td>
                                @endif

                                @if ($status === 'pending')
                                    <td class="d-flex flex-column gap-1">

                                                                                <!-- Approve Button (Disabled if no staff assigned) -->
                                        <form action="{{ route('maintenance.approve', $request->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-success btn-sm"
                                                    {{ !$request->staff_id ? 'disabled' : '' }}>
                                                Approve
                                            </button>
                                        </form>

                                        <!-- Reject Button -->
                                        <form action="{{ route('maintenance.reject', $request->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $status === 'pending' ? 7 : ($status === 'approved' ? 5 : 5) }}" class="text-center">
                                    No {{ $status }} requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</div>

<!-- Bootstrap JS (optional if already included elsewhere) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
