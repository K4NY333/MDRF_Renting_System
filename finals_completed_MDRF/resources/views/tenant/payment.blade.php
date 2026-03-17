<style>
body {
    min-height: 100vh;
    min-width: 100vw;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f5eee6 60%, #eab566 100%);
    font-family: "Poppins", sans-serif;
}

.gcash-payment-center {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    background: #fff;
    padding: 40px 32px 32px 32px;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(139, 94, 60, 0.12);
    min-width: 320px;
    max-width: 95vw;
}

.gcash-payment-center h2 {
    margin-bottom: 24px;
    color: #4a3c1a;

}
.gcash-payment-center .qr-code {
    margin-bottom: 18px;
}
.gcash-payment-center p {
    font-size: 1.1rem;
    color: #5d4a38;
    margin-top: 10px;
}
.gcash-payment-center a {
    margin-top: 28px;
    display: inline-block;
    padding: 12px 32px;
    background: #1976d2;
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: background 0.2s;
    box-shadow: 0 1px 6px rgba(25, 118, 210, 0.07);

}

.gcash-payment-center a:hover {
    background: #1251a3;
    color: #fff;
}
</style>

<div class="gcash-payment-center">
    <h2>Pay via GCash</h2>
    <div class="qr-code">
        {!! $qrCode !!}
    </div>
    <p>Scan to pay: {{ $payment->roomTenant->room->place->owner->contact_number }}</p>
    <a href="{{ route('tenant.payment') }}" >Back to Payments</a>
</div>
