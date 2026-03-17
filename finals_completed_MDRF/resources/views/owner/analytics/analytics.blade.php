@vite(['resources/css/owner/analytics.css'])

<div id="analytics" class="modal-header1">
    <h1>Analytics & Reports</h1>
</div>

<div class="dashboard-grid-analytics" style="display: flex; flex-direction: column; gap: 32px;">
    <div class="card-analytics">
        <h3>Monthly Revenue Trend</h3>
        <div class="chart-container">
            <div class="monthly-revenue-center">
                <div class="monthly-revenue-amount">
                    ₱{{ number_format($monthlyRevenue, 2) }}
                </div>
                <div>This Month</div>
                <div class="monthly-revenue-status">
                    @if ($collectionRate >= 100)
                        100% Collected
                    @elseif ($collectionRate >= 90)
                        ↑ Excellent Collection
                    @else
                        ↓ Needs Attention
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card-analytics">
        <h3>Financial Summary</h3>
        <div class="financial-summary-analytics">
            <div class="stat-card">
                <div class="stat-number">₱{{ number_format($monthlyRevenue, 0) }}</div>
                <div class="stat-label">Monthly Revenue</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">₱{{ number_format($outstandingDues, 0) }}</div>
                <div class="stat-label">Outstanding Dues</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $collectionRate }}%</div>
                <div class="stat-label">Collection Rate</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">₱{{ number_format($maintenanceCost, 0) }}</div>
                <div class="stat-label">Maintenance Cost</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    @if ($tax > 0)
                        ₱{{ number_format($tax, 0) }}
                    @else
                        No Tax
                    @endif
                </div>
                <div class="stat-label">Tax (if applicable)</div>
            </div>
        </div>
    </div>
</div>