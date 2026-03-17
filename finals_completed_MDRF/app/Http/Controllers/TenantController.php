<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\RoomTenant;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TenantController extends Controller
{
public function tenantDashboard()
{
    $tenant = Auth::user();

    $roomTenants = RoomTenant::with(['room.place.owner', 'room.roomImages'])
        ->where('tenant_id', $tenant->id)
        ->where('status', 'renting')
        ->get();

    return view('tenant.dashboard', [
        'tenant' => $tenant,
        'roomTenants' => $roomTenants
    ]);
}
  public function index()
    {
        $tenant = Auth::user();
 
        $payments = Payment::with(['roomTenant.room.place.owner'])
            ->where('tenant_id', $tenant->id)
            ->orderBy('due_date', 'asc')
            ->get();

        return view('tenant.payment.index', compact('tenant', 'payments'));
    }


    public function uploadProof(Request $request, $paymentId)
{
    $request->validate([
        'proof' => 'required|image|max:2048',
    ]);

    $payment = Payment::where('id', $paymentId)
                      ->where('tenant_id', Auth::id())
                      ->firstOrFail();

    $path = $request->file('proof')->store('payment_proofs', 'public');

    $payment->proof_path = $path;
    $payment->status = 'pending'; // Waiting for admin approval
    $payment->save();

    return redirect()->back()->with('success', 'Payment proof uploaded successfully. Please wait for admin confirmation.');
}


public function showPaymentPage($roomTenantId)
{
    $tenant = auth()->user(); // optional: for logging or validation

    logger()->info('Entering showPaymentPage()', [
        'tenant_id' => $tenant->id ?? 'guest',
        'roomTenantId' => $roomTenantId,
    ]);

    // Get the first unpaid payment for this roomTenantId
    $payment = Payment::with('roomTenant.room.place.owner')
        ->where('room_tenant_id', $roomTenantId)
        ->where('status', 'unpaid')
        ->firstOrFail();

    // Owner's contact number or fallback
    $ownerContact = optional($payment->roomTenant->room->place->owner)->contact_number ?? '09171234567';

    // Route that leads to the receipt or payment processing page
    $receiptUrl = route('tenant.payment.receipt', ['payment' => $payment->id]);

    // Generate QR code to show in modal or section
    $qrCode = QrCode::size(250)->generate($receiptUrl);

    return view('tenant.payment', compact('payment', 'qrCode', 'ownerContact'));
}


public function showReceipt(Payment $payment)
{
    $payment->load('roomTenant.room.place.owner', 'tenant');

    $ownerContact = optional($payment->roomTenant->room->place->owner)->contact_number ?? '09171234567';

    // Only update if unpaid
    if ($payment->status === 'unpaid') {
        $payment->update([
            'status' => 'paid',
            'paid_date' => now(),
        ]);
    }
     $nextDueDate = $payment->due_date->copy()->addMonth();

        // Optional: Prevent duplicate future payments
        $exists = Payment::where('room_tenant_id', $payment->room_tenant_id)
                         ->whereDate('due_date', $nextDueDate)
                         ->exists();

      if (!$exists) {
            Payment::create([
                'room_tenant_id' => $payment->room_tenant_id,
                'tenant_id'      => $payment->tenant_id,
                'tenant_name'      => $payment->tenant_name,
                'amount'         => $payment->amount, // or calculate new amount if needed
                'due_date'       => $nextDueDate,
                'status'         => 'unpaid',
                'method'         => 'gcash'// default or same as current
            ]);
        }
    

    return view('tenant.payment.receipt', [
        'payment' => $payment,
        'ownerContact' => $ownerContact,
    ]);         
}


public function downloadReceipt(Payment $payment)
{
    $pdf = Pdf::loadView('tenant.payment.receipt', compact('payment'));
    return $pdf->download("receipt_{$payment->id}.pdf");
}

// delete
public function destroyPayment($id)
{
    $payment = Payment::findOrFail($id);

    // Optional: Check if the payment belongs to the authenticated tenant
    if ($payment->tenant_id !== auth()->id()) {
        abort(403, 'Unauthorized');
    }

    $payment->delete();

    return redirect()->route('tenant.payment')->with('success', 'Payment record deleted successfully.');
}   



    public function requestTermination(Request $request, $id)
    {
        $tenantRecord = RoomTenant::findOrFail($id);

        if (auth()->id() !== $tenantRecord->tenant_id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'end_date' => 'required|date|after_or_equal:today',
        ]);

        $tenantRecord->termination_requested = true;
        $tenantRecord->end_date = $request->end_date;
        $tenantRecord->save();

        return back()->with('success', 'Termination request with end date submitted.');
    }
}