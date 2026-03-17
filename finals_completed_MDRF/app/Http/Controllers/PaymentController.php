<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\RoomTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use Carbon\Carbon;
    
class PaymentController extends Controller
{

    
public function store(Request $request)
{
    $path = null;

    if ($request->hasFile('qr_proof')) {
        $path = $request->file('qr_proof')->store('qr_proofs', 'public');
    }

    Payment::create([
        'room_tenant_id' => $request->room_tenant_id,
        'tenant_id' => Auth::id(),
        'amount' => $request->amount,
        'due_date' => $request->due_date,
        'method' => $path ? 'cash' : 'gcash',
        'qr_proof' => $path,
        'status' => 'unpaid', // to be updated by admin after checking
    ]);

    return back()->with('success', 'Payment submitted. Awaiting confirmation.');
}
public function confirmPayment($paymentId)
{
    $payment = Payment::findOrFail($paymentId);
    $payment->update([
        'status' => 'paid',
        'paid_date' => now(),
        'confirmed_by' => Auth::id()
    ]);

    return redirect()->route('owner.payments')->with('success', 'Payment confirmed.');
}




}


