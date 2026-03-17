<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant | Payment Dashboard</title>

    <!-- Bootstrap CSS (required for modal to show properly) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+5hb7ie3ffM/iW2Fyz2JxkdOU6YXz7CDsHxSefb" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap JS Bundle (already correct) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QsRtFh3AnmJtXk5yQG5IG7gLp5xv5V1uMsz+u9N7vvN7nUV5tP+LMjWJghdugEXm" crossorigin="anonymous"></script>

    <!-- Vite styles -->
    @vite(['resources/css/tenant/payment.css'])
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

    <div class="main-container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="mascot">
                <img src="{{ asset('assets/mascot-transparent.png') }}" alt="Mascot">
            </div>
            <div class="mascot-welcome">
                <div class="welcome-content">
                    <h1 class="welcome-text">Welcome, {{ Auth::user()->name }}!</h1>
                    <div class="action-buttons">
                    <button class="btn" onclick="openCustomModal()">PAY NOW</button>
                        <a href="{{ route('tenant') }}" class="btn">BACK</a>
                    </div>
                </div>
                <div class="avatar">
                    <img src="{{ asset(Auth::user()->image_path) }}" alt="Avatar"> 
                </div>
            </div>
        </div>

        <!-- Paid Payments Section -->
        <div class="container">
            <h1>Payment History</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Due Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Method</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $paidPayments = $payments->filter(fn($payment) => $payment->status === 'paid');
                    @endphp

                   @forelse ($paidPayments as $payment)
                        <tr>
                            <td>{{ $payment->due_date->format('Y-m-d') }}</td>
                            <td>₱{{ number_format($payment->amount, 2) }}</td>
                            <td><span style="color:green;">PAID</span></td>
                            <td>{{ ucfirst($payment->method ?? 'Unknown') }}</td>
                            <td>
                                <a href="{{ route('tenant.payment.download', $payment->id) }}" class="btn btn-sm btn-primary" title="Download Receipt">
                                    <i class="fa fa-download"></i>
                                </a>
                                
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No paid payment records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- QR Modal -->
    <div id="qrModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); justify-content:center; align-items:center;">
        <div style="background:white; padding:20px; border-radius:10px; text-align:center;">
            <h2>GCash Payment QR</h2>
            <img id="qrImage" src="" alt="QR Code" style="max-width:300px;">
            <br><br>
            <button onclick="closeQR()">Close</button>
        </div>
    </div>

   <!-- Custom Modal -->
<div id="customModal" class="custom-modal">
  <div class="custom-modal-content">
    <span class="close-btn" onclick="closeCustomModal()">&times;</span>
    <h2>Unpaid Payments</h2>
    <table class="table">
      <thead>
        <tr>
          <th>Due Date</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Method</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @php
            $unpaidPayments = $payments->filter(fn($payment) => $payment->status === 'unpaid');
        @endphp

        @forelse ($unpaidPayments as $payment)
          <tr>
            <td>{{ $payment->due_date->format('Y-m-d') }}</td>
            <td>₱{{ number_format($payment->amount, 2) }}</td>
            <td><span style="color:red;">UNPAID</span></td>
            <td>{{ ucfirst($payment->method ?? 'Unknown') }}</td>
            <td>
              @if ($payment->method === 'gcash')
              <form action="{{ route('tenant.payment.page', $payment->room_tenant_id) }}" method="GET" style="display:inline;">
                <button type="submit">Pay Now</button>
              </form>
              @endif    
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5">No unpaid payment records found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>


    <!-- Scripts -->
 <script>
function openCustomModal() {
  document.getElementById("customModal").style.display = "block";
}

function closeCustomModal() {
  document.getElementById("customModal").style.display = "none";
}
</script>

    <footer>
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
                <div class="social-link"><i class="fab fa-facebook-f"></i></div>
                <div class="social-link"><i class="fab fa-facebook-messenger"></i></div>
                <div class="social-link"><i class="fab fa-instagram"></i></div>
            </div>
        </div>
        <div class="copyright">
            <p>© 2025 MDRF. All rights reserved.</p>
        </div>
    </footer>
</body>
<!-- Bootstrap 5 JS Bundle with Popper (required for modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QsRtFh3AnmJtXk5yQG5IG7gLp5xv5V1uMsz+u9N7vvN7nUV5tP+LMjWJghdugEXm" crossorigin="anonymous"></script>

</html>
