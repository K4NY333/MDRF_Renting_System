@vite(['resources/css/owner/payments/payment.css'])

<head>
    <title>Owner | Tenant Payments</title>
</head>

<div>
    <h2>Tenant Payments</h2>

    <!-- Navigation Tabs -->
    <div class="tab-row" id="paymentTabs" role="tablist">
        <div class="tab-row-item" role="presentation">
            <button class="nav-link active" id="unpaid-tab" data-bs-toggle="tab" data-bs-target="#unpaid" type="button" role="tab" aria-controls="unpaid" aria-selected="true">
                Unpaid Tenants
            </button>
        </div>
        <div class="tab-row-item" role="presentation">
            <button class="nav-link" id="paid-tab" data-bs-toggle="tab" data-bs-target="#paid" type="button" role="tab" aria-controls="paid" aria-selected="false">
                Paid Tenants
            </button>
        </div>
    </div>

    <!-- Tab Contents -->
    <div class="tab-content mt-3" id="paymentTabsContent">
        <!-- Unpaid Tab -->
        <div class="tab-pane fade show active" id="unpaid" role="tabpanel" aria-labelledby="unpaid-tab">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tenant</th>
                        <th>Room Name</th>
                        <th>Due Date</th>
                        <th>Amount</th>
                        <th>QR</th>
                        <th>ACTION</th>
                     
                    </tr>
                </thead>
                <tbody>
                    @forelse ($unpaidPayments as $payment)
                    @continue(is_null($payment->tenant_id))
                        <tr>
                            <td>{{ $payment->tenant_name }}</td>
                            <td>{{ $payment->roomTenant->room->name ?? 'N/A' }}</td>
                            <td class="{{ $payment->due_date->isPast() ? 'text-danger fw-bold' : '' }}">
                                {{ $payment->due_date->format('Y-m-d') }}
                            </td>
                            <td>₱{{ number_format($payment->amount, 2) }}</td>
                            <td>
                       
                                <button class="btn btn-primary"
                                    onclick="openDashboardPopup('{{ route('owner.payment.qr', $payment->room_tenant_id) }}', 400, 450)">
                                    Show QR
                                </button>
                               
                            </td>
                            
                            <td>
                                <a href="{{ route('owner_mark', $payment->id) }}" class="btn btn-success">Mark Paid</a>
                    </td>
                        </tr> 
                    @empty
                        <tr>
                            <td colspan="8">No unpaid payments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paid Tab -->
        <div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tenant</th>
                        <th>Room Name</th>
                        <th>Paid Date</th>
                        <th>Method</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($paidPayments as $payment)
                        <tr>
                            <td>{{ $payment->tenant_name }}</td>
                            <td>{{ $payment->roomTenant->room->name ?? 'N/A' }}</td>
                            <td>{{ $payment->updated_at->format('Y-m-d') }}</td>
                            <td>{{ $payment->method ?? 'N/A' }}</td>
                            <td>₱{{ number_format($payment->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No paid tenants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
