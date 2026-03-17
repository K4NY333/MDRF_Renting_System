<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDRF Admin Dashboard</title>
    @vite('resources/css/admin.css')
</head>
<body>
    <header class="header">
        <div class="logo">MDRF</div>
        <div class="admin-info">
            <span>Admin Panel</span>
            <div class="admin-avatar">A</div>
        </div>
    </header>

    <div class="main-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Property Management Dashboard</h1>
            <button class="btn btn-primary">+ Add New Property</button>
        </div>

        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-number">156</div>
                <div class="stat-label">Total Properties</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">89</div>
                <div class="stat-label">Active Tenants</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">23</div>
                <div class="stat-label">Property Owners</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">12</div>
                <div class="stat-label">Pending Applications</div>
            </div>
        </div>

        <div class="filters">
            <div class="filter-group">
                <label>Property Type</label>
                <select>
                    <option>All Types</option>
                    <option>Studio</option>
                    <option>1 Bedroom</option>
                    <option>2 Bedroom</option>
                    <option>3 Bedroom</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Status</label>
                <select>
                    <option>All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>Pending</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Location</label>
                <select>
                    <option>All Locations</option>
                    <option>Davao City</option>
                    <option>Calamba</option>
                    <option>Laguna</option>
                </select>
            </div>
            <button class="btn btn-primary">Search</button>
            <button class="btn btn-secondary">Reset</button>
        </div>

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

            <div class="table-section">
                <div class="table-header">Account Management</div>
                <div class="table-content">
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Account Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Michael Chen</td>
                                <td>michael.chen@email.com</td>
                                <td>Tenant</td>
                                <td><span class="status pending">Pending Activation</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">Activate</button>
                                        <button class="btn btn-danger btn-sm">Reject</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Anna Rodriguez</td>
                                <td>anna.rodriguez@email.com</td>
                                <td>Property Owner</td>
                                <td><span class="status pending">Pending Activation</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">Activate</button>
                                        <button class="btn btn-danger btn-sm">Reject</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>James Wilson</td>
                                <td>james.wilson@email.com</td>
                                <td>Tenant</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-warning btn-sm">Suspend</button>
                                        <button class="btn btn-success btn-sm">View Profile</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Patricia Lee</td>
                                <td>patricia.lee@email.com</td>
                                <td>Property Owner</td>
                                <td><span class="status inactive">Suspended</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">Reactivate</button>
                                        <button class="btn btn-success btn-sm">View Profile</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Kevin Martinez</td>
                                <td>kevin.martinez@email.com</td>
                                <td>Tenant</td>
                                <td><span class="status pending">Pending Activation</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">Activate</button>
                                        <button class="btn btn-danger btn-sm">Reject</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                                <th>Properties</th>
                                <th>Total Revenue</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Daniel Rojas</td>
                                <td>8 units</td>
                                <td>₱176,000</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">View</button>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Francis Saragoza</td>
                                <td>12 units</td>
                                <td>₱264,000</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">View</button>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Rianne Gonzales</td>
                                <td>6 units</td>
                                <td>₱132,000</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">View</button>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Ranzes Madera</td>
                                <td>4 units</td>
                                <td>₱88,000</td>
                                <td><span class="status pending">Pending</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        <button class="btn btn-danger btn-sm">Reject</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Michael Torres</td>
                                <td>10 units</td>
                                <td>₱220,000</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">View</button>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-section">
                <div class="table-header">Termination Requests</div>
                <div class="table-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Tenant</th>
                                <th>Property</th>
                                <th>Requested by</th>
                                <th>Reason</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>David Garcia</td>
                                <td>Palm Residences A-203</td>
                                <td>Michael Torres</td>
                                <td>Lease violation</td>
                                <td>
                                    <div class="action-buttons">
                                        <span class="status terminated" style="padding: 0.25rem 0.5rem;">Processed</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Alex Thompson</td>
                                <td>Palm Residences B-301</td>
                                <td>Francis Saragoza</td>
                                <td>Non-payment</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">Review</button>
                                        <button class="btn btn-warning btn-sm">Contact Tenant</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Emma Davis</td>
                                <td>Palm Residences C-102</td>
                                <td>Daniel Rojas</td>
                                <td>Property damage</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-success btn-sm">Review</button>
                                        <button class="btn btn-warning btn-sm">Schedule Meeting</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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
    </div>
</body>
</html>