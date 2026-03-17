@vite(['resources/css/owner/payments/qr.css'])

<div class="container">
    <h2>Pay via Cash</h2>
    <div class="text-center">
        {!! $qrCode !!}
        <p class="mt-3">Scan this QR to access the receipt and mark the payment.</p>
    </div>

    <hr>

    <h4>Payment Info</h4>
    <p><strong>Tenant:</strong> {{ $payment->tenant->name }}</p>
    <p><strong>Room:</strong> {{ $payment->tenant_name ?? 'N/A' }}</p>
    <p><strong>Amount:</strong> ₱{{ number_format($payment->amount, 2) }}</p>
    <p><strong>Due Date:</strong> {{ $payment->due_date->format('F d, Y') }}</p>
    <p><strong>Status:</strong> <span style="color:red;">Unpaid</span></p>
    <p><strong>Contact Owner:</strong> {{ $ownerContact }}</p>

    
</div>

