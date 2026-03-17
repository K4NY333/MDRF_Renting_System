<head>
    <title>Owner Dashboard</title>
</head>

@vite(['resources/css/owner/dashboard.css'])
@vite(['resources/css/owner/rooms/create.css']) 
@vite(['resources/js/owner.js'])
 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
 
<div class="dashboard">
    <nav class="sidebar">
       <div class="logo" style="display: flex; flex-direction: column; align-items: center; gap: 0px;">
    <h1 style="margin:0;">MDRF</h1>
    @if(Auth::user()->image_path)
        <img src="{{ asset(Auth::user()->image_path) }}" alt="Profile" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #b89b7a;">
    @else
        <img src="{{ asset('default-avatar.png') }}" alt="Profile" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #b89b7a;">
    @endif
    <p style="margin:0; margin-top:8px;">{{ Auth::user()->name }}'s Portal</p>
</div>

<ul class="nav-menu">  
        <li class="nav-item" onclick="openDashboardPopup('{{ route('owner.applications.index') }}')">
            <a href="javascript:void(0);" class="nav-link">
                <i class="bi bi-people-fill nav-icon"></i>
                <span class="nav-text">Tenants</span>
            </a>
        </li>
    <li class="nav-item" onclick="openDashboardPopup('{{ route('places.create') }}')">
        <a href="javascript:void(0);" class="nav-link">
            <i class="bi bi-plus-square nav-icon"></i>
            <span class="nav-text">Add place</span>
        </a>
    </li>
    <li class="nav-item" onclick="openDashboardPopup('{{ route('places.show') }}')">
        <a href="javascript:void(0);" class="nav-link">
            <i class="bi bi-building nav-icon"></i>
            <span class="nav-text">View place</span>
        </a>
    </li>
    <li class="nav-item" onclick="openDashboardPopup('{{ route('owner.payments') }}')">
        <a href="javascript:void(0);" class="nav-link">
            <i class="bi bi-cash-stack nav-icon"></i>
            <span class="nav-text">Payments</span>
        </a>
    </li>
    <li class="nav-item" onclick="openDashboardPopup('{{ route('owner.maintenance') }}')">
    <a href="javascript:void(0);" class="nav-link">
        <i class="bi bi-tools nav-icon"></i>
        <span class="nav-text">Services</span>
    </a>
</li>

  <li class="nav-item" onclick="openDashboardPopup('{{ route('staff.index') }}')">
    <a href="javascript:void(0);" class="nav-link">
        <i class="bi bi-person-gear nav-icon"></i>
        <span class="nav-text">Staff</span>
    </a>
</li>

    <li class="nav-item" onclick="openDashboardPopup('{{ route('owner.analytics') }}')">
        <a href="javascript:void(0);" class="nav-link">
            <i class="bi bi-bar-chart-line-fill nav-icon"></i>
            <span class="nav-text">Analytics</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('auth.logout_loading') }}" class="nav-link" style="cursor: pointer;">
            <i class="bi bi-box-arrow-right nav-icon"></i>
            <span class="nav-text">Sign Out</span>
        </a>
    </li>
</ul>
</nav>


<script>
    document.querySelectorAll('.nav-link').forEach(item => {
        item.addEventListener('click', function (e) {
            const isActive = this.classList.contains('active');
 
            // Remove 'active' from all links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
 
            // Toggle 'active' only if it wasn't already active
            if (!isActive) {
                this.classList.add('active');
            }
        });
    });
</script>
 
 
    <!-- Dashboard container -->
    <div class="dashboard-container">
    <h2>Owner Dashboard</h2>

    <div class="dashboard-metrics">
        <div class="metric-card">
            <div>Total Places</div>
            <div><h5>{{ $totalPlaces }}</h5></div>
        </div>
        <div class="metric-card">
            <div>Total Rooms</div>
            <div><h5>{{ $totalRooms }}</h5></div>
        </div>
        <div class="metric-card">
            <div>Total Staff</div>
            <div><h5>{{ $totalStaff }}</h5></div>
        </div>
        
    </div>

     <!-- <div class="dashboard-news" style="margin-top: 32px;">
        <h4>News</h4>
        <p>Stay tuned for updates and announcements here.</p>
    </div>   -->

</div>
 
<!-- Slide-in Panel -->
<div class="dashboard-popup-panel hidden" id="dashboardPopupPanel">
    <div class="popup-panel-content" id="dashboardPopupContent">
        <!-- Dynamic AJAX content or details -->
    </div>
</div>

@if(session('success'))
    <div class="alert-alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert-alert-danger" role="alert" style="background:#f8d7da; color:#842029; border:1px solid #f5c2c7; position:fixed; top:80px; left:50%; transform:translateX(-50%); z-index:99999; min-width:320px; max-width:90vw; text-align:center; box-shadow:0 4px 24px rgba(0,0,0,0.12); font-size:1.1rem; padding:1rem 2rem; border-radius:8px;">
        {{ session('error') }}
    </div>
@endif
