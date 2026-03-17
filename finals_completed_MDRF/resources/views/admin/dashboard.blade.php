<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <title>MDRF Admin Dashboard</title>
    @vite('resources/css/admin.css')
     @vite('resources/js/admin.js')
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<section>
    <header class="header">
        <div class="logo">MDRF</div>
     <div class="admin-info">
    <span>Admin Panel</span>
    <div class="admin-avatar">A</div>
    <div class="dropdown-content">
        <a href="{{ route('auth.logout_loading') }}" class="nav-link" style="cursor: pointer;">
              @csrf
              <button type="submit">Logout</button>
          </a>

    </div>
</div>

    </header>

    <div class="main-container">
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-number"> {{$roomCount}}</div>
                <div class="stat-label">Total Properties</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{$tenantCount}}</div>
                <div class="stat-label">Active Tenants</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{$ownerCount}}</div>
                <div class="stat-label">Property Owners</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{$applicantCount}}</div>
                <div class="stat-label">Pending Applications</div>
            </div>
        </div>


<!--Account Management -->
<section id="account" class="account">
  <div class="table-section" data-type="account-managment">

    <div class="table-header">
      Account Management
      <hr style="border: none; height: 2px; background-color: black; margin-top: 10px;">
    </div>

    <div class="searchh" style="margin: 15px 0;">
      <form method="GET" action="{{ route('admin') }}#account" class="eme">
        <input type="text" name="name" placeholder="Search by name" value="{{ request('name') }}">
        <input type="email" name="email" placeholder="Search by email" value="{{ request('email') }}">
        <select name="role">
          <option value="">All Roles</option>
          <option value="tenant" {{ request('role') == 'tenant' ? 'selected' : '' }}>Tenant</option>
          <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>Owner</option>
        </select>
        <button type="submit">Filter</button>
      </form>
    </div>

    <div class="table-content">
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
            <tr>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ ucfirst($user->role) }}</td>
              <td>
                @if ($user->role === 'owner' && $user->application)
                  <span class="status {{ strtolower($user->application->status) }}">
                    {{ ucfirst($user->application->status) }}
                  </span>
                @elseif ($user->role === 'tenant' && $user->roomTenant)
                  <span class="status {{ strtolower($user->roomTenant->status) }}">
                    {{ ucfirst($user->roomTenant->status) }}
                  </span>
                @else
                  <span class="status active">Active</span>
                @endif
              </td>
              <td class="action-buttons">
                <button class="btn btn-primary btn-sm edit-user-btn" data-user-id="{{ $user->id }}"><i class="bi bi-pencil-square"></i></button>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>
</section>

{{--Edit form Pop Up--}}    
<div class="popup-overlay" id="editUserPopup" style="display:none;">
    <div class="popup-container">
        <div class="popup-close" id="closeEditUserPopup">×</div>

        <div class="edit-user-form" id="editUserFormContainer">
            {{-- The form will be dynamically inserted here --}}
        </div>
    </div>
</div>


<!--Applicants table -->
<section id="applicants" class="Applicants">
        <div class="tables-container" data-type="property-owners">


<div class="table-section">
                <div class="table-header">Landlord Applicants
                    <hr style="border: none; height: 2px; background-color: black; margin-top: 8px;">
                </div>
               <div class="searchh">
  <form method="GET" action="{{ route('admin') }}#applicants" class="searchh">
      <input type="text" name="applicant_name" placeholder="Search by name" value="{{ request('applicant_name') }}">
      <input type="email" name="applicant_email" placeholder="Search by email" value="{{ request('applicant_email') }}">
      <select name="status">
          <option value="">All Statuses</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
          <option value="rejected" {{ request('status') == 'activated' ? 'selected' : '' }}>Activated</option>
      </select>
      <button type="submit">Filter</button>
  </form>
  </div>
                <div class="table-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Applicant Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                  <tbody>
    @forelse ($applicants as $applicant)
        <tr>
            <td>{{ $applicant->name }}</td>
            <td>{{ $applicant->email }}</td>
            <td>{{ $applicant->contact_number }}</td>
            <td>{{ $applicant->status }}</td>
            <td>
                <button class="btn btn-primary btn-sm btn-view view-pdf-btn" data-pdf-url="{{ asset($applicant->pdf_path) }}">
                    <i class="bi bi-eye"></i> View PDF
                </button>

               @if ($applicant->status === 'approved')
                     <button class="btn btn-secondary btn-sm" disabled>Approved</button>
            @elseif ($applicant->status === 'pending')
 <form action="{{ route('admin.approve', $applicant->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm"
                            onclick="return confirm('Are you sure you want to approve this user?')">Approve</button>
                    </form>
@elseif ($applicant->status === 'activated')
    <button class="btn btn-info btn-sm" disabled>Activated</button>
@endif
                    
    

                <form action="{{ route('admin.applicant.destroy', $applicant->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this user?')"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No applicants found.</td>
        </tr>
    @endforelse
</tbody>
                       
                    </table>
                </div>
            </div>
</div>
</section>
<!-- pop-up for view pdf -->            
<div class="popup-overlay" id="pdfPopup" style="display:none;">
    <div class="popup-container" style="width: 80%; height: 90%;">
        <div class="popup-close" id="closePdfPopup" style="cursor: pointer; font-size: 24px;">×</div>
        <iframe id="pdfViewer" style="width: 100%; height: 100%;" frameborder="0"></iframe>
    </div>
</div>

<!--Owner Management -->
<section id="own" class="own">           
  <div class="tables-container">
    <div class="table-section">
      
      <div class="table-header">Property Owner<hr style="border: none; height: 2px; background-color: black; margin-top: 8px;"></div>

      <!-- Search Bar -->
      <div class="searchh">
          <form method="GET" action="{{ route('admin') }}#own" class="eme">
            <input
              type="text"
              name="location"
              placeholder="Filter by Location"
              value="{{ request('location') }}"
            >
            <input
              type="number"
              name="rooms"
              placeholder="Number of Rooms"
              value="{{ request('rooms') }}"
              min="0"
            >
            <input
              type="number"
              name="tenants"
              placeholder="Number of Tenants"
              value="{{ request('tenants') }}"
              min="0"
            >
            <button type="submit">Filter</button>
          </form>
        </div>

      <div class="table-content">
        <table>
          <thead>
            <tr>
              <th>Owner Name</th>
              <th>Total Places</th>
              <th>Total Rooms</th>
              <th>Total Tenants</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($owners as $data)
              <tr>
                <td>{{ $data['owner']->name }}</td>
                <td>{{ $data['place_count'] }}</td>
                <td>{{ $data['room_count'] }}</td>
                <td>{{ $data['tenant_count'] }}</td>
                <td class="action-buttons">
                  <button class="btn btn-success btn-sm view-owner-btn" data-owner-id="{{ $data['owner']->id }}"><i class="bi bi-eye"></i> View Owner</button>
                  <button class="btn btn-primary btn-sm edit-user-btn" data-user-id="{{ $data['owner']->id }}"><i class="bi bi-pencil-square"></i></button>
                  <form action="{{ route('admin.users.destroy', $data['owner']->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this owner?')"><i class="bi bi-trash"></i></button>
                  </form>
                </td>
              </tr>

              <!-- Owner Detail Panel -->
              <div class="property-details-overlay" id="propertyPanel-{{ $data['owner']->id }}">
                <div class="property-details-content">
                  <div class="property-details-close" onclick="closePanel('propertyPanel-{{ $data['owner']->id }}')">&times;</div>
                  <h1 class="property-title">{{ $data['owner']->name }}</h1>
                  <img class="avatarIMG" src="{{ asset($data['owner']->image_path) }}">
                  
                  @if ($data['owner_place']->count())
                    @foreach ($data['owner_place'] as $place)
                      <div class="place-card-horizontal">
                        <img src="{{ asset($place->image_path) }}" class="place-img" alt="Place Image">
                        <div class="place-info">
                          <h2 class="property-subtitle">{{ $place->name }}</h2>
                          <p><i class="fas fa-map-marker-alt"></i> {{ $place->location }}</p>
                          <p>{{ $place->description }}</p>
                          <form action="{{ route('place.destroy', $place->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this place?')"><i class="bi bi-trash"></i></button>
                                       </form>
                        </div>
                      </div>

                      @php
                        $placeRooms = $data['owner_room']->where('place_id', $place->id);
                      @endphp

                      @if ($placeRooms->count())
                        <div class="room-section">
                          <h3 class="property-details-heading">Rooms in {{ $place->name }}</h3>
                          <div class="carousel-wrapper">
                            <button class="carousel-btn left" onclick="scrollCarousel(this, -1)">&#10094;</button>
                            <div class="rooms-carousel-container">
                              <div class="rooms-carousel">
                                @foreach ($placeRooms as $room)
                                  <div class="room-card"
                                    onclick='showRoomDetails(
                                      @json($room->id),
                                      @json($room->roomImages->pluck("image_path")),
                                      @json(ucfirst($room->type)),
                                      @json($room->capacity),
                                      @json(number_format($room->price, 2)),
                                      @json($room->description ?? "No description available")
                                    )'>
                                    @if ($room->roomImages->count())
                                      <img src="{{ asset($room->roomImages->first()->image_path) }}" alt="Room Image">
                                    @else
                                      <img src="{{ asset('default-room.jpg') }}" alt="No Image">
                                    @endif
                                    <div class="room-info">
                                      <p><strong>{{ ucfirst($room->type) }}</strong></p>
                                      <p>Cap: {{ $room->capacity }}</p>
                                      <p>₱{{ number_format($room->price, 2) }}</p>
                                      <form action="{{ route('room.destroy', $room->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this room?')"><i class="bi bi-trash"></i></button>
                                       </form>
                                   </div>
                                  </div>
                                @endforeach
                              </div>
                            </div>
                            <button class="carousel-btn right" onclick="scrollCarousel(this, 1)">&#10095;</button>
                          </div>
                        </div>
                      @else
                        <p>No rooms listed under this place.</p>
                      @endif
                    @endforeach
                  @else
                    <p>This owner has no listed places or rooms.</p>
                  @endif
                </div>
              </div>

            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<div id="roomModal" class="room-modal">
  <div class="room-modal-content">
    <div id="roomModalBody"></div>
  </div>
</div>
<script>

</script>

<!--Tenant Management -->
<section id="ten" class="ten">    
    <div class="table-section">
        <div class="table-header">
            Tenant
            <div style="border: none; height: 2px; background-color: black; margin-top: 8px;"></div>
        </div>

        <div class="searchh">
            <form method="GET" action="{{ route('admin') }}#ten" class="searchh">
                <input
                    type="text"
                    name="location"
                    placeholder="Filter by Location"
                    value="{{ request('location') }}"
                >

                <select name="status">
                    <option value="">All Statuses</option>
                    <option value="renting" {{ request('status') == 'renting' ? 'selected' : '' }}>Renting</option>
                    <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                </select>

                <button type="submit">Filter</button>
            </form>
        </div>

        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th>Tenant</th>
                        <th>Property Renting</th>
                        <th>Landlord</th>
                        <th>Status</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tenants as $data)
                        @php
                            $endDate = isset($data['roomTenant']) ? \Carbon\Carbon::parse($data['roomTenant']->end_date) : null;
                            $today = \Carbon\Carbon::today();
                            $rowClass = '';

                            if ($endDate) {
                             $daysDiff = $today->diffInDays($endDate, false); 
                                if ($endDate->isSameDay($today)) {
                                    $rowClass = 'bg-red';
                                } elseif ($daysDiff > 0 && $daysDiff <= 3) {
                $rowClass = 'bg-yellow';
            }

                            }
                        @endphp

                        <tr class="{{ $rowClass }}">
                            <td>{{ $data['tenant']->name }}</td>
                            <td>{{ optional($data['room'])->id ?? 'N/A' }}</td>
                            <td>{{ optional($data['landlord'])->name ?? 'N/A' }}</td>
                            <td>{{ isset($data['roomTenant']) ? ucfirst($data['roomTenant']->status) : 'N/A' }}</td>
                            <td>{{ isset($data['roomTenant']) ? $endDate->format('F d, Y') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<style>
    .bg-red {
        background-color: #ffcccc; /* Light red for today's end date */
    }
    .bg-yellow {
        background-color: #fff3cd; /* Light yellow for 2 days before end date */
    }
</style>

       
{{-- Session Success Message --}}
@if(session('success'))
    <div id="session-success-alert" class="alert-alert-success" role="alert" style="background:#d1e7dd; color:#0f5132; border:1px solid #badbcc; position:fixed; top:32px; left:50%; transform:translateX(-50%); z-index:99999; min-width:320px; max-width:90vw; text-align:center; box-shadow:0 4px 24px rgba(0,0,0,0.12); font-size:1.1rem; padding:1rem 2rem; border-radius:8px;">
        {{ session('success') }}
    </div>
@endif

{{-- Session Error Message --}}
@if(session('error'))
    <div id="session-error-alert" class="alert-alert-danger" role="alert" style="background:#f8d7da; color:#842029; border:1px solid #f5c2c7; position:fixed; top:80px; left:50%; transform:translateX(-50%); z-index:99999; min-width:320px; max-width:90vw; text-align:center; box-shadow:0 4px 24px rgba(0,0,0,0.12); font-size:1.1rem; padding:1rem 2rem; border-radius:8px;">
        {{ session('error') }}
    </div>
@endif

<script>
    // Hide session alerts after 1 second
    window.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var success = document.getElementById('session-success-alert');
            var error = document.getElementById('session-error-alert');
            if(success) success.style.display = 'none';
            if(error) error.style.display = 'none';
        }, 1000);
    });
</script>