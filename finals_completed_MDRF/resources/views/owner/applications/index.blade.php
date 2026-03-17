<head>
    <title>Owner | Tenant Applications</title>
    @vite(['resources/css/owner/applications/index.css'])  
</head>

<div>
    <h2 class="applications-title">Tenant Applications</h2>

    <!-- Navigation Tabs -->
    <div class="tab-row" id="applicationTabs" role="tablist" style="margin-bottom: 18px;">
        <div class="tab-row-item" role="presentation">
            <button class="nav-link active" id="tenants-tab" data-bs-toggle="tab" data-bs-target="#tenants" type="button" role="tab" aria-controls="tenants" aria-selected="true">
                Tenants
            </button>
        </div>
        <div class="tab-row-item" role="presentation">
            <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="false">
                Pending
            </button>
        </div>
        <div class="tab-row-item" role="presentation">
            <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab" aria-controls="approved" aria-selected="false">
                Approved
            </button>
        </div>
    </div>

    <!-- Tab Contents -->
    <div class="tab-content mt-3" id="applicationTabsContent">

        <!-- Tenants Tab -->
      <div class="tab-pane fade show active" id="tenants" role="tabpanel" aria-labelledby="tenants-tab">
    <table class="applications-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Room</th>
                <th>Place</th>
                <th>Started Renting</th>
                <th>Status</th>     
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tenants as $tenant)
               @continue(is_null($tenant->tenant->email ?? null))
                <tr>
                    <td>{{ $tenant->tenant->name ?? 'N/A' }}</td>
                    <td>{{ $tenant->tenant->email ?? 'N/A' }}</td>
                    <td>{{ $tenant->tenant->contact_number ?? 'N/A' }}</td>
                    <td>{{ $tenant->room->id ?? 'N/A' }}</td>
                    <td>{{ $tenant->room->place->name ?? 'N/A' }}</td>
                    <td>{{ $tenant->start_date }}</td>
                    <td>
                     @if($tenant->termination_requested)
                    <span class="status-pending">Termination Requested</span>
                @elseif($tenant->status === 'renting')
                    <span class="status-active">Renting</span>
                @elseif($tenant->status === 'terminated')
                    <span class="status-rejected">Terminated</span>
                @else
                    <span>{{ ucfirst($tenant->status) }}</span>
                @endif
                    </td>
                    <td>
                      @if($tenant->termination_requested)
                            <form method="POST" action="{{ route('owner.approveTermination', $tenant->id) }}">
                                @csrf
                                <button type="submit" class="approve-btn">Approve Termination</button>
                            </form>
                        @else
                            <span>-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="no-data">No tenants found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
        <!-- Pending Tab -->
        <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
            <table class="applications-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Room</th>
                        <th>Place</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications->where('status', 'pending') as $application)
                        <tr>
                            <td>{{ $application->name }}</td>
                            <td>{{ $application->email ?? 'N/A' }}</td>
                            <td>{{ $application->contact_number ?? 'N/A' }}</td>
                            <td>{{ $application->room->id ?? 'N/A' }}</td>
                            <td>{{ $application->room->place->name ?? 'N/A' }}</td>
                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                            <td><span class="status-pending">Pending</span></td>
                            <td>
                                <div class="actions">
                                    <form method="POST" action="{{ route('approve_tenant', $application->id) }}">
                                        @csrf
                                        <button type="submit" class="approve-btn">Approve</button>
                                    </form>
                                    <button class="view-pdf-btn" data-pdf-url="{{ asset($application->pdf_path) }}">View PDF</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="no-data">No pending applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Approved Tab -->
        <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
            <table class="applications-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Room</th>
                        <th>Place</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications->where('status', 'approved') as $application)
                        <tr>
                            <td>{{ $application->name }}</td>
                            <td>{{ $application->email ?? 'N/A' }}</td>
                            <td>{{ $application->contact_number ?? 'N/A' }}</td>
                            <td>{{ $application->room->id ?? 'N/A' }}</td>
                            <td>{{ $application->room->place->name ?? 'N/A' }}</td>
                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                            <td><span class="status-active">Approved</span></td>
                            <td>
                                <div class="actions">
                                    <button class="view-pdf-btn" data-pdf-url="{{ asset($application->pdf_path) }}">View PDF</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="no-data">No approved applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- PDF Popup -->
<div class="pdf-popup-overlay" id="pdfPopup" style="display: none;">
    <div class="pdf-popup-container">
        <div class="pdf-popup-close" id="closePdfPopup">×</div>
        <iframe id="pdfViewer" class="pdf-viewer" frameborder="0"></iframe>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- PDF Viewer JS -->
<script>
    document.querySelectorAll('.view-pdf-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const pdfUrl = this.dataset.pdfUrl;
            document.getElementById('pdfViewer').src = pdfUrl;
            document.getElementById('pdfPopup').style.display = 'block';
        });
    });

    document.getElementById('closePdfPopup')?.addEventListener('click', function () {
        document.getElementById('pdfPopup').style.display = 'none';
        document.getElementById('pdfViewer').src = '';
    });
</script>

<!-- Styling -->
<style>
.tab-row {
    display: flex;
    gap: 10px;
    border-bottom: 2px solid #e7d3b8;
}
.tab-row-item {
    margin-bottom: -2px;
}
.tab-row .nav-link {
    border: none;
    background: #f5eee6;
    color: #7c532d;
    border-radius: 12px 12px 0 0;
    font-weight: 600;
    font-size: 1rem;
    padding: 10px 28px;
    transition: background 0.2s, color 0.2s;
}
.tab-row .nav-link.active,
.tab-row .nav-link:hover {
    background: #7c532d;
    color: #fff;
}
.status-active { color: #388e3c; font-weight: bold; }
.status-pending { color: #ff9800; font-weight: bold; }
.status-rejected { color: #d32f2f; font-weight: bold; }

.pdf-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}
.pdf-popup-container {
    position: relative;
    width: 80%;
    height: 80%;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
}
.pdf-popup-close {
    position: absolute;
    top: 10px;
    right: 14px;
    font-size: 28px;
    cursor: pointer;
    color: #000;
}
.pdf-viewer {
    width: 100%;
    height: 100%;
}
</style>
