<style>
:root {
    --earth-brown: #8b5e3c;
    --earth-tan: #b89b7a;
    --earth-green: #7a8450;
    --earth-cream: #f5eee6;
    --earth-dark: #4e342e;
    --earth-accent: #c97d60;
}

body {
    background: var(--earth-cream, #f5eee6);
    min-height: 100vh;
    margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
}

h2 {
    text-align: center;
    color: var(--earth-dark);
    font-size: 2rem;
    margin-bottom: 28px;
    margin-top: 24px;
    letter-spacing: 1px;
}

.r-container {
    max-width: 420px;
    margin: 48px auto;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(139, 94, 60, 0.1);
    padding: 32px 28px 24px 28px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.r-container p {
    font-size: 1.08rem;
    color: var(--earth-brown);
    margin: 12px 0;
    letter-spacing: 0.2px;
    width: 100%;
}

.r-container strong {
    color: var(--earth-dark);
    font-weight: 600;
}

.r-container a {
    display: inline-block;
    margin-top: 24px;
    background: #1976d2;
    color: #fff;
    text-decoration: none;
    padding: 10px 28px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    transition: background 0.2s;
    box-shadow: 0 1px 6px rgba(25, 118, 210, 0.07);
}

.r-container a:hover {
    background: #1251a3;
    color: #fff;
}

@media (max-width: 600px) {
    .r-container {
        padding: 18px 6px 14px 6px;
        max-width: 98vw;
    }
    h2 {
        font-size: 1.3rem;
    }
    .r-container a {
        width: 100%;
        text-align: center;
        padding: 12px 0;
    }
}
</style>

<div class="r-container">
    <h2>Payment Receipt</h2>

    <p><strong>Name:</strong> {{ $payment->tenant_name }}</p>
    <p><strong>Room:</strong> {{ $payment->roomTenant->room->id ?? 'N/A' }}</p>
    <p><strong>Amount:</strong> ₱{{ number_format($payment->amount, 2) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
    <p><strong>Method:</strong> {{ ucfirst($payment->method) }}</p>
    <p><strong>Reference:</strong> MDRF2025-{{ $payment->id }}</p>
    <p><strong>Date Paid:</strong> {{ $payment->paid_date ?? 'Not yet paid' }}</p>

    <div style="display: flex; gap: 16px; justify-content: center; margin-top: 24px;">
    <a href="{{ route('tenant.payment.download', $payment->id) }}">Download as PDF</a>
    <a href="{{ route('tenant.payment') }}">Back to Payments</a>
</div>
</div>