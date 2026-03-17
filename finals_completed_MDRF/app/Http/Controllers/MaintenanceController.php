<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomTenant;
use App\Models\Room;
use App\Models\MaintenanceRequest; 
use Illuminate\Support\Facades\Auth;
class MaintenanceController extends Controller
{

// Show tenant's maintenance requests
    public function tenantRequests()
    {
        $user = Auth::user();

        $requests = MaintenanceRequest::where('tenant_id', $user->id)
                    ->with('roomTenant.room.place.owner')
                    ->latest()
                    ->get();

        return view('tenant.maintenance.tenant_requests', compact('requests'));
    }

    // Store new maintenance request
    public function store(Request $request)
{
    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'description' => 'required|string|max:1000',
       'service_type_id' => 'required|in:housekeeping,laundry,electric_maintenance,water_maintenance,repair,security_system,waste_management', // assuming IDs are static values for manual options
    ]);

    $tenantId = auth()->id();

    $isTenantOfRoom = RoomTenant::where('room_id', $request->room_id)
        ->where('tenant_id', $tenantId)
        ->where('status', 'renting')
        ->exists();

    if (!$isTenantOfRoom) {
        return back()->withErrors('You are not renting this room.');
    }

    MaintenanceRequest::create([
        'room_id' => $request->room_id,
        'tenant_id' => $tenantId,
        'description' => $request->description,
        'service_type' => $request->service_type_id,
        'status' => 'pending',
    ]);

    return back()->with('success', 'Maintenance request submitted.');
}


    public function approve($id)
{
    $request = MaintenanceRequest::findOrFail($id);

    // Optional: ensure the authenticated user is the owner of the place related to this request
    if (auth()->user()->id !== $request->room->place->owner_id) {
        abort(403, 'Unauthorized');
    }

    $request->status = 'approved';
    $request->save();

    return back()->with('success', 'Maintenance request approved.');
}

public function reject($id)
{
    $request = MaintenanceRequest::findOrFail($id);

    if (auth()->user()->id !== $request->room->place->owner_id) {
        abort(403, 'Unauthorized');
    }

    $request->status = 'rejected';
    $request->save();

    return back()->with('success', 'Maintenance request rejected.');
}
public function update(Request $request, $id)
{
    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'description' => 'required|string|max:1000',
         'service_type_id' => 'required|in:housekeeping,laundry,electric_maintenance,water_maintenance,repair,security_system_maintenance,waste_management',   
    ]);

    $maintenance = MaintenanceRequest::findOrFail($id);
    $maintenance->room_id = $request->room_id;
    $maintenance->description = $request->description;
     $maintenance->service_type = $request->service_type_id;  
    $maintenance->save();

    return redirect()->route('maintenance.tenant_requests')->with('success', 'Maintenance request updated successfully.');
}
public function destroy($id)
{
    $request = MaintenanceRequest::findOrFail($id);

    // Optional: Only allow the tenant who created the request to delete it
    if (auth()->id() !== $request->tenant_id) {
        abort(403, 'Unauthorized');
    }

    $request->delete();

    return redirect()->route('maintenance.tenant_requests')->with('success', 'Maintenance request deleted successfully.');
}


}

