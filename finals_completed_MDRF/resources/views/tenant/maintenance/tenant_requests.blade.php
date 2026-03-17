<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <title>Tenant | Maintenance Dashboard</title>

    @vite('resources/css/tenant/maintenance.css')
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="{{ asset('assets/sample-logo.png') }}" alt="MDRF Logo" class="imglogo">
            <div class="logo-text">
                <h1>MDRF</h1>
                <p>APARTMENT RENTAL FOR ALL</p>
            </div>
        </div>
    </header>

    <div class="notification-alerts">
        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    
    <div class="main-container">
        <div class="welcome-section">
                <div class="mascot">
                    <img src="{{ asset('assets/mascot-transparent.png') }}" alt="Mascot">
                </div>

                <div class="mascot-welcome">
                    <div class="welcome-content">
                        <h1 class="welcome-text">Welcome, {{ Auth::user()->name }}!</h1>
                        <div class="action-buttons">
                            <div class="action-buttons">
                                <button class="btn" id="openRequestModalBtn">NEW REQUEST</button>                                
                                <a href="{{ route('tenant') }}" class="btn">BACK</a>
                            </div>
                        </div>
                    </div>

                    <div class="avatar">
                        <img src="{{ asset(Auth::user()->image_path) }}" alt="Avatar"> 
                    </div>
                </div>
        </div>

        <div class="requests-section">
            <div class="section-title">My Maintenance Requests</div>

            @if($requests->isEmpty())
                <p>No maintenance requests found.</p>
            @else
                <div class="table-responsive mt-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Room Name</th>
                                <th>Place</th>
                                <th>Service Type</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Requested At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $req)
                            <tr>
                                <td>{{ $req->room->name ?? 'N/A' }}</td>
                                <td>{{ $req->room->place->name ?? 'N/A' }}</td>
                                <td>{{ $req->service_type }}</td>
                                <td>{{ $req->description }}</td>
                                <td>
                                    @if ($req->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($req->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif ($req->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($req->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $req->created_at->format('M d, Y | h:i A') }}</td>
                                <td>
                                    <div class="d-flex gap-2 flex-wrap">
                                       @if ($req->status !== 'approved')
                                    <a href="javascript:void(0);" 
                                        class="btn btn-sm btn-primary edit-request-btn"
                                        data-id="{{ $req->id }}"
                                        data-room="{{ $req->room_id }}"
                                        data-description="{{ $req->description }}"
                                        data-action="{{ route('maintenance.requests.update', $req->id) }}">
                                        Edit
                                    </a>
                                @endif

                                        <form action="{{ route('maintenance.requests.destroy', $req->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this request?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal" id="addRequestModal" tabindex="-1" aria-labelledby="addRequestModalLabel" aria-hidden="true" style="display:none;"> 
        <div class="modal-dialog">
            <form method="POST" action="{{ route('maintenance.requests.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRequestModalLabel">New Maintenance Request</h5>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="room_id" class="form-label">Select Room</label>
                            <select name="room_id" id="room_id" class="form-select" required>
                                <option value="" selected disabled>Choose a room</option>
                                @foreach(Auth::user()->roomsApplied as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }} - {{ $room->place->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                     <div class="mb-3">
                        <label for="service_type_id" class="form-label">Select Service Type</label>
                        <select name="service_type_id" id="service_type_id" class="form-control" required>
                            <option value="">-- Select Service Type --</option>
                            <option value="housekeeping">Housekeeping</option>
                            <option value="laundry">Laundry</option>
                            <option value="electric_maintenance">Electrical Maintenance</option>
                            <option value="water_maintenance">Water Maintenance</option>
                            <option value="repair">Repair</option>
                            <option value="security_system">Security System</option>
                            <option value="waste_management">Waste Management</option>
                        </select>
                        @error('service_type_id')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description of Issue</label>
                            <textarea name="description" id="description" rows="4" class="form-control" placeholder="Describe your request" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

 <!-- Edit Request Modal -->
<div class="modal" id="editRequestModal" tabindex="-1" aria-labelledby="editRequestModalLabel" aria-hidden="true" style="display:none;">
    <div class="modal-dialog">
        <form id="editRequestForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRequestModalLabel">Edit Maintenance Request</h5>
                    <button type="button" class="btn-close" id="closeEditModalBtn"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_room_id" class="form-label">Room</label>
                        <input type="text" id="edit_room_id" name="room_id" class="form-control" readonly>
                    </div>
                     <div class="mb-3">
                        <label for="service_type_id" class="form-label">Select Service Type</label>
                        <select name="service_type_id" id="service_type_id" class="form-control" required>
                            <option value="">-- Select Service Type --</option>
                            <option value="housekeeping">Housekeeping</option>
                            <option value="laundry">Laundry</option>
                            <option value="electric_maintenance">Electrical Maintenance</option>
                            <option value="water_maintenance">Water Maintenance</option>
                            <option value="repair">Repair</option>
                            <option value="security_system">Security System</option>
                            <option value="waste_management">Waste Management</option>
                        </select>
                        @error('service_type_id')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea id="edit_description" name="description" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeEditModalBtnFooter">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Request</button>
                </div>
            </div>
        </form>
    </div>
</div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('addRequestModal');
            const openBtn = document.getElementById('openRequestModalBtn');
            const closeBtns = modal.querySelectorAll('[data-close-modal], .btn[data-bs-dismiss="modal"]');

            // Open modal
            openBtn.addEventListener('click', function() {
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            // Close modal on Cancel or background click
            closeBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                    document.body.style.overflow = '';
                });
            });

            // Optional: Close modal when clicking outside modal-dialog
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });

            // Edit modal logic
            const editModal = document.getElementById('editRequestModal');
            const closeEditBtn = document.getElementById('closeEditModalBtn');
            const closeEditBtnFooter = document.getElementById('closeEditModalBtnFooter'); // Add this line
            const editForm = document.getElementById('editRequestForm');
            const editRoom = document.getElementById('edit_room_id');
            const editDesc = document.getElementById('edit_description');

            document.querySelectorAll('.edit-request-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Set form action
                    editForm.action = btn.getAttribute('data-action');
                    // Set values
                    editRoom.value = btn.getAttribute('data-room');
                    editDesc.value = btn.getAttribute('data-description');
                    // Show modal
                    editModal.style.display = 'block';
                    editModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                });
            });

            closeEditBtn.addEventListener('click', function() {
                editModal.style.display = 'none';
                editModal.classList.remove('show');
                document.body.style.overflow = '';
            });

            // Add this block for the Cancel button
            closeEditBtnFooter.addEventListener('click', function() {
                editModal.style.display = 'none';
                editModal.classList.remove('show');
                document.body.style.overflow = '';
            });

            editModal.addEventListener('click', function(e) {
                if (e.target === editModal) {
                    editModal.style.display = 'none';
                    editModal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>  

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <h2>MDRF</h2>
                    <p>Apartment Rentals</p>
                </div>
                    
                <div class="footer-contact">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Calamba, Laguna, Philippines</p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <p>0999-999-9999</p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <p>mdrf1234@gmail.com</p>
                    </div>
                </div>
                    
                <div class="footer-links">
                    <h3>Support</h3>
                    <ul>
                        <li>Terms and Conditions</li>
                        <li>Privacy Policy</li>
                    </ul>
                </div>
                    
                <div class="footer-links">
                    <h3>Developers</h3>
                    <ul>
                        <li>Daniel Rojas</li>
                        <li>Francis Saragoza</li>
                        <li>Rianne Gonzales</li>
                        <li>Ranzes Madera</li>
                    </ul>
                </div>
                    
                <div class="social-links">
                    <div class="social-link">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                    <div class="social-link">
                        <i class="fab fa-facebook-messenger"></i>
                    </div>
                    <div class="social-link">
                        <i class="fab fa-instagram"></i>
                    </div>
                </div>
            </div>
                
            <div class="copyright">
                <p>© 2025 MDRF. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
