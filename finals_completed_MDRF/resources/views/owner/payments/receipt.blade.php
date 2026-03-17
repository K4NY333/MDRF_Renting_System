@vite(['resources/css/owner/payments/receipt.css'])

@php
    use Illuminate\Support\Str;
@endphp
<div class="r-container">
    <h2>Payment Receipt</h2>

    <p><strong>Tenant Name:</strong> {{ $payment->tenant->name }}</p>
    <p><strong>Room:</strong> {{ $payment->roomTenant->room->name ?? 'N/A' }}</p>
    <p><strong>Amount:</strong> ₱{{ number_format($payment->amount, 2) }}</p>
    <!-- <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p> -->
    <!-- <p><strong>Method:</strong> {{ ucfirst($payment->method) }}</p> -->
    <p><strong>Reference:</strong> MDRF2025-{{ $payment->id }}</p>
    <p><strong>Date Paid:</strong> {{ $payment->paid_date ?? 'Not yet paid' }}</p>
    <!-- <p><strong>Confirmed By:</strong> {{ $payment->roomTenant->room->place->owner->name ?? 'Not confirmed' }}</p> -->
    <p><strong>Payment Date:</strong> {{ $payment->created_at->format('F d, Y') }}</p>

    @if($payment->qr_proof)
        <p><strong>QR Proof:</strong></p>
        @if(Str::startsWith(trim($payment->qr_proof), '<?xml') || Str::startsWith(trim($payment->qr_proof), '<svg'))
            {!! $payment->qr_proof !!}
        @else
            <img src="{{ asset($payment->qr_proof) }}" alt="QR Code Proof" width="250">
        @endif
    @endif

    <div style="display: flex; gap: 12px; margin-top: 24px;">
        <a href="{{ route('owner') }}" class="btn-back">Back</a>
        <a href="{{ route('owner.payment.download', $payment->id) }}">Download as PDF</a>
    </div>
</div>