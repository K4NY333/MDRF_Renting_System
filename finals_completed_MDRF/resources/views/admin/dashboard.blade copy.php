<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MDRF Admin Dashboard</title>
    @vite('resources/css/admin.css')
     @vite('resources/js/admin.js')
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="header">
        <div class="logo">MDRF</div>
     <div class="admin-info">
    <span>Admin Panel</span>
    <div class="admin-avatar">A</div>
    <div class="dropdown-content">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

    </header>

    <div class="main-container">
        <!-- <div class="dashboard-header">
            <h1 class="dashboard-title">Property Management Dashboard</h1>
            <button class="btn btn-primary">+ Add New Property</button>
        </div> -->

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
<form method="GET" action="{{ route('admin') }}">
    <div class="filters">
        <div class="filter-group">
            <label>Property Type</label>
            <select name="property_type">
                <option>All Types</option>
                <option value="bedspacer">Bedspacer</option>
                <option value="private">Private</option>
                <option value="shared">Shared</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Tenant Status</label>
            <select name="tenant_status">
                <option>All Status</option>
                <option value="pending">Pending</option>
                <option value="renting">Renting</option>
                <option value="terminated">Terminated</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Owner Status</label>
            <select name="owner_status">
                <option>All Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="activated">Activated</option>
            </select>
        </div>
       <div class="filter-group">
    <label>Location</label>
    <select name="location">
        <option>All Locations</option>
        @foreach ($locations as $loc)
            <option value="{{ $loc }}">{{ $loc }}</option>
        @endforeach
    </select>
</div>

        <button type="submit" class="btn btn-primary">Search</button>
        <a href="{{ route('admin') }}" class="btn btn-secondary">Reset</a>
    </div>
</form>



        <!-- <div class="tables-container">
            <div class="table-section">
                <div class="table-header">Tenants Management</div>
                <div class="table-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Property</th>
                                <th>Rent</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>Palm Residences A-101</td>
                                <td>₱22,000</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">View</button>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Maria Santos</td>
                                <td>Palm Residences B-205</td>
                                <td>₱22,000</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">View</button>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Robert Chen</td>
                                <td>Palm Residences C-301</td>
                                <td>₱22,000</td>
                                <td><span class="status pending">Pending</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        <button class="btn btn-danger btn-sm">Reject</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Lisa Wang</td>
                                <td>Palm Residences D-102</td>
                                <td>₱22,000</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">View</button>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>David Garcia</td>
                                <td>Palm Residences A-203</td>
                                <td>₱22,000</td>
                                <td><span class="status terminated">Terminated</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-danger btn-sm">Delete Record</button>
                                        <button class="btn btn-success btn-sm">View Details</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Sarah Johnson</td>
                                <td>Palm Residences B-104</td>
                                <td>₱22,000</td>
                                <td><span class="status inactive">Inactive</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">Activate</button>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> -->

    <div class="table-section" data-type="account-managment" >
    <div class="table-header">Account Management</div>
    <div class="table-content">
    <table>
        <thea>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thea>
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
                      <button class="btn btn-primary btn-sm edit-user-btn" data-user-id="{{ $user->id }}">Edit</button>



                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    </div>
</div>

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

        <div class="tables-container" data-type="property-owners">
            <div class="table-section">
                <div class="table-header">Landlord Applicants</div>
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
                            @foreach ($applicants as $applicant)
                <tr>
                    <td>{{ $applicant->name }}</td>
                    <td>{{ $applicant->email }}</td>
                    <td>{{ $applicant-> contact_number }}</td>
                    <td>{{ $applicant-> status }}</td>
                  
 <td> <button class="btn btn-primary btn-sm btn-view view-pdf-btn" data-pdf-url="{{ asset($applicant->pdf_path) }}">
    View PDF
</button>


                      @if ($applicant->status === 'approved')
                        <button class="btn btn-secondary btn-sm" disabled>Approved</button>
                    @else
                        <form action="{{ route('admin.approve', $applicant->id) }}" method="POST" style="display:inline;">
                            @csrf   
                            <button type="submit" class="btn btn-success btn-sm"
                                    onclick="return confirm('Are you sure you want to approve this user?')">Approve</button>
                        </form>
                    @endif
                     <form action="{{ route('admin.applicant.destroy', $applicant->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
                       
                    </table>
                </div>
            </div>

<!-- pop-up for view pdf -->            
<div class="popup-overlay" id="pdfPopup" style="display:none;">
    <div class="popup-container" style="width: 80%; height: 90%;">
        <div class="popup-close" id="closePdfPopup" style="cursor: pointer; font-size: 24px;">×</div>
        <iframe id="pdfViewer" style="width: 100%; height: 100%;" frameborder="0"></iframe>
    </div>
</div>


             
<div class="tables-container">
    <div class="table-section">
        <div class="table-header">Property Owners</div>
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
                                  <button class="btn btn-primary btn-sm edit-user-btn" data-user-id="{{ $data['owner']->id }}">Edit</button>

                                <form action="{{ route('admin.users.destroy', $data['owner']->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this owner?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- tenant -->
            <div class="table-section">
                <div class="table-header">Tenant</div>
                <div class="table-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Tenant</th>
                                <th>Property Renting</th>
                                <th>Landlord</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($tenants as $data)

               <tr>
    <td>{{ $data['tenant']->name }}</td>
    <td>{{ $data['room']->id }}</td>
    <td>{{ $data['landlord']->name }}</td>
    <td>{{ ucfirst($data['roomTenant']->status) }}</td>
 
<td>
                      @if ($applicant->status === 'approved')
                        <button class="btn btn-secondary btn-sm" disabled>Approved</button>
                    @else
                        <form action="{{ route('admin.approve', $applicant->id) }}" method="POST" style="display:inline;">
                            @csrf   
                            <button type="submit" class="btn btn-success btn-sm"
                                    onclick="return confirm('Are you sure you want to approve this user?')">Approve</button>
                        </form>
                    @endif
                     <form action="{{ route('admin.applicant.destroy', $applicant->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
                    </table>
                </div>
            </div>
        </div> 


        <!--
        <div class="interactions-section">
            <h2 style="margin-bottom: 1rem; color: #8B4513;">Recent Tenant-Owner Interactions</h2>
            
            <div class="interaction-item">
                <div class="interaction-details">
                    <div class="interaction-type">Termination Request</div>
                    <div class="interaction-description">Michael Torres requested termination of David Garcia's lease due to lease violation</div>
                    <div style="font-size: 0.8rem; color: #999; margin-top: 0.25rem;">6 hours ago</div>
                </div>
                <div class="interaction-actions">
                    <button class="btn btn-success btn-sm">Process Termination</button>
                    <button class="btn btn-warning btn-sm">Review Case</button>
                </div>
            </div>

            <div class="interaction-item">
                <div class="interaction-details">
                    <div class="interaction-type">Account Activation</div>
                    <div class="interaction-description">Michael Chen submitted documents for tenant account activation</div>
                    <div style="font-size: 0.8rem; color: #999; margin-top: 0.25rem;">3 hours ago</div>
                </div>
                <div class="interaction-actions">
                    <button class="btn btn-success btn-sm">Activate Account</button>
                    <button class="btn btn-warning btn-sm">Request More Info</button>
                </div>
            </div>

            <div class="interaction-item">
                <div class="interaction-details">
                    <div class="interaction-type">Maintenance Request</div>
                    <div class="interaction-description">Maria Santos requested AC repair - forwarded to Francis Saragoza</div>
                    <div style="font-size: 0.8rem; color: #999; margin-top: 0.25rem;">5 hours ago</div>
                </div>
                <div class="interaction-actions">
                    <button class="btn btn-warning btn-sm">Update Status</button>
                    <button class="btn btn-primary btn-sm">Contact Owner</button>
                </div>
            </div>

            <div class="interaction-item">
                <div class="interaction-details">
                    <div class="interaction-type">Payment Confirmation</div>
                    <div class="interaction-description">Lisa Wang's monthly rent payment processed to Rianne Gonzales</div>
                    <div style="font-size: 0.8rem; color: #999; margin-top: 0.25rem;">1 day ago</div>
                </div>
                <div class="interaction-actions">
                    <button class="btn btn-success btn-sm">View Receipt</button>
                    <button class="btn btn-secondary btn-sm">Send Confirmation</button>
                </div>
            </div>

            <div class="interaction-item">
                <div class="interaction-details">
                    <div class="interaction-type">Lease Renewal</div>
                    <div class="interaction-description">David Garcia's lease renewal pending approval from Michael Torres</div>
                    <div style="font-size: 0.8rem; color: #999; margin-top: 0.25rem;">2 days ago</div>
                </div>
                <div class="interaction-actions">
                    <button class="btn btn-warning btn-sm">Review Terms</button>
                    <button class="btn btn-primary btn-sm">Facilitate Meeting</button>
                </div>
            </div>

            <div class="interaction-item">
                <div class="interaction-details">
                    <div class="interaction-type">Application Review</div>
                    <div class="interaction-description">Robert Chen's application for Palm Residences C-301 under review by Daniel Rojas</div>
                    <div style="font-size: 0.8rem; color: #999; margin-top: 0.25rem;">3 days ago</div>
                </div>
                <div class="interaction-actions">
                    <button class="btn btn-success btn-sm">Expedite Review</button>
                    <button class="btn btn-warning btn-sm">Request Documents</button>
                </div>
            </div>
        </div>
    </div> -->
     <!-- <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
    </form> -->
</body>
</html>

