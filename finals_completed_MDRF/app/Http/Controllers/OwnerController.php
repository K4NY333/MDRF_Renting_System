<?php


    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Mail;
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use App\Mail\ActivationCodeMail;
    use App\Models\RoomImage;
    use App\Models\Applicant; 
    use App\Models\Staff; 
    use App\Models\Place; 
    use App\Models\Payment; 
    use App\Models\Room;
    use App\Models\RoomTenant;
    use Barryvdh\DomPDF\Facade\Pdf;
    use App\Models\MaintenanceRequest;  
    use App\Mail\TenantTerminatedNotification;
    use App\Mail\StaffMaintenanceAssigned;
    use App\Models\User;

    class OwnerController extends Controller
    {

        
    
public function index()
{
    $ownerId = Auth::id();

    $totalPlaces = Place::where('user_id', $ownerId)->count();
    $totalRooms = Room::whereIn('place_id', Place::where('user_id', $ownerId)->pluck('id'))->count();
    $totalStaff = Staff::where('owner_id', $ownerId)->count();

    // Eager load rooms and their images for this owner
    $place = Place::with('rooms.images')->where('user_id', $ownerId)->get();

    return view('owner.dashboard', compact('totalPlaces', 'totalRooms', 'totalStaff', 'ownerId'));
}

    
        public function createPlace()
    {
        return view('owner.places.create');
    }
        public function storePlace(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'type' => 'required|in:apartment,bungalow',
            'image_file' => 'required|image|max:5048',  // use image_file not image_path
        ]);

    
        // Handle Image upload
        $image = $request->file('image_file');
        $imageFilename = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images/place_images'), $imageFilename);
        
        // Add image_path to validated array
        $validated['image_path'] = 'images/place_images/' . $imageFilename;
        // Store place under the authenticated user
        $place = Auth::user()->places()->create($validated);

        return redirect()->route('owner')->with('success', 'Place added successfully.');
    }

    public function showPlace()
    {
    $ownerId = Auth::id();

        // Eager load rooms and their images for this owner
        $places = Place::with('rooms.images')->where('user_id', $ownerId)->get();

        return view('owner.places.show', compact('places'));
    }


    public function showRoom($id)
        {
            // Eager load images to reduce DB queries
            $room = Room::with('images')->findOrFail($id);

            return view('owner.places.room', compact('room'));
        }

        //rooms
    // Show form to create a room for a specific place
    public function createRoom(Request $request)
    {
        // You expect place_id in the query string, so validate it exists
        $place = Place::findOrFail($request->place_id);
        return view('owner.rooms.create', compact('place'));
    }

    // Store a new room linked to a place
    public function storeRoom(Request $request)
    {

        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'place_id' => 'required|exists:places,id',
            'type' => 'required|in:bedspacer,private,shared',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10248',
            'status' => 'required|in:Available,Occupied,Under Maintenance',
            'kitchen_equipment' => 'nullable|string|max:1000',
        'furniture_equipment' => 'nullable|string|max:1000',
        'cctv' => 'sometimes|boolean',
        'laundry_area' => 'sometimes|boolean',
        'allowed_pets' => 'sometimes|boolean',
        'has_wifi' => 'sometimes|boolean',
        ]);

        // Create the room
        $place = Place::findOrFail($validated['place_id']);
        $room = $place->rooms()->create($validated);

        // Save images to public/images/room_images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/room_images'), $filename);

                $room->images()->create([
                    'image_path' => 'images/room_images/' . $filename,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Room and images added successfully.');
    }

    public function indexStaff()
{
    // You can filter by the logged-in owner if needed
    // For now, we get all staff
   $staffMembers = Staff::where('owner_id', Auth::id())->get();
    
   if ($staffMembers->isEmpty()) {
        return redirect()->route('staff.create')->with('info', 'Please add your first staff member.');
    }


    return view('owner.staffs.index', compact('staffMembers'));
}

    public function createStaff()
    {
        return view('owner.staffs.create');
    }

    // Store staff
    public function storeStaff(Request $request)
    {
        $request->validate([
            'owner_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staffs,email',
            'contact_number' => 'nullable|string|max:20',
            'service_type' => 'required|in:housekeeping,laundry,electric_maintenance,water_maintenance,repair,security_system_maintenance,waste_management',
            'image_path' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
    $filename = time() . '_' . $request->file('image_path')->getClientOriginalName();
    $request->file('image_path')->move(public_path('images/staff_images'), $filename);
    $imagePath = 'images/staff_images/' . $filename;
}


        Staff::create([
            'owner_id' => $request->owner_id,
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'service_type' => $request->service_type,
            'image_path' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Staff member created successfully!');
    }




    public function editStaff($id)
{
    $staff = Staff::findOrFail($id);
    return view('owner.staffs.edit', compact('staff'));
}
    public function updateStaff(Request $request, $id)
{
    $staff = Staff::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:staffs,email,' . $staff->id,
        'contact_number' => 'nullable|string|max:20',
        'service_type' => 'required|in:housekeeping,laundry,electric_maintenance,water_maintenance,repair,security_system_maintenance,waste_management',
        'image_path' => 'nullable|image|max:2048',
    ]);

    $staff->name = $request->name;
    $staff->email = $request->email;
    $staff->contact_number = $request->contact_number;
    $staff->service_type = $request->service_type;

    if ($request->hasFile('image_path')) {
        // Delete old image if exists
        if ($staff->image_path && file_exists(public_path($staff->image_path))) {
            unlink(public_path($staff->image_path));
        }

        $filename = time() . '_' . $request->file('image_path')->getClientOriginalName();
        $request->file('image_path')->move(public_path('images/staff_images'), $filename);
        $staff->image_path = 'images/staff_images/' . $filename;
    }

    $staff->save();

    return redirect()->back()->with('success', 'Staff updated successfully.');
}



public function destroyStaff($id)
{
    $staff = Staff::findOrFail($id);

    // Delete image if exists
    if ($staff->image_path && file_exists(public_path($staff->image_path))) {
        unlink(public_path($staff->image_path));
    }

    $staff->delete();

    return redirect()->back()->with('success', 'Staff deleted successfully.');
}
    //approving applicants-tenants
    public function listApplications()
    {
        $ownerId = auth()->id();

        $roomIds = Room::whereHas('place', function ($query) use ($ownerId) {
            $query->where('user_id', $ownerId);
        })->pluck('id');

        $applications = Applicant::whereIn('room_id', $roomIds)
            ->with('room') // optional, if you want room details
            ->get();

            $tenants = RoomTenant::whereIn('room_id', $roomIds)
            ->with(['tenant', 'room.place']) // assuming tenant is the user renting
            ->get();


        return view('owner.applications.index', compact('applications', 'tenants'));
    }
public function approveTermination($id)
{
    $tenant = RoomTenant::findOrFail($id);

    // Ensure the tenant is currently renting and has requested termination
    if ($tenant->termination_requested && $tenant->status === 'renting') {
        $tenant->termination_requested = false; // clear the request flag
        $tenant->status = 'terminated';         // update status to 'terminated'
        $tenant->end_date;              // set end date to now
        $tenant->save();

        // Optional: Free up the room, notify tenant, log activity, etc.
    }

    return redirect()->back()->with('success', 'Termination approved and status updated to terminated.');
}



        public function approveApplication($id)
        {
            $application = Applicant::findOrFail($id);

            if ($application->status === 'approved') {
                return redirect()->back()->with('info', 'This application is already approved.');
            }

            $activationCode = strtoupper(Str::random(8));
            $application->update([
                'status' => 'approved',
                'activation_code' => $activationCode,
            ]);

        Mail::to($application->email)->send(new ActivationCodeMail($activationCode, $application->name));


            return redirect()->back()->with('success', 'Application approved and activation code sent.');
        }       


    public function ownerPayments()
    {
        $owner = auth()->user(); // Authenticated owner

        // Get all unpaid payments
        $unpaidPayments = Payment::with(['tenant', 'roomTenant.room.place'])
            ->whereHas('roomTenant.room.place', function ($q) use ($owner) {
                $q->where('user_id', $owner->id);
            })
            ->where('status', 'unpaid')
            ->get();

        // Get all paid payments
        $paidPayments = Payment::with(['tenant', 'roomTenant.room.place'])
            ->whereHas('roomTenant.room.place', function ($q) use ($owner) {
                $q->where('user_id', $owner->id);
            })
            ->where('status', 'paid')
            ->get();

        return view('owner.payments.index', compact('unpaidPayments', 'paidPayments'));
    }
        
    public function showOwnerPaymentPage($roomTenantId)
    {
        $owner = auth()->user();

        logger()->info('Entering showOwnerPaymentPage()', [
            'owner_id' => $owner->id,
            'roomTenantId' => $roomTenantId,
        ]);

        $payment = Payment::with('roomTenant.room.place.owner', 'tenant')
            ->where('room_tenant_id', $roomTenantId)
            ->whereHas('roomTenant.room.place', function ($query) use ($owner) {
                $query->where('user_id', $owner->id);
            })
            ->where('status', 'unpaid')
            ->firstOrFail();

        $ownerContact = optional($payment->roomTenant->room->place->owner)->contact_number ?? '09171234567';
        $receiptUrl = route('owner_mark', ['payment' => $payment->id]);
        $qrCode = QrCode::size(250)->generate($receiptUrl); // defaults to SVG

        return view('owner.payments.qr', compact('payment', 'qrCode', 'ownerContact'));
    }

        public function showCashReceipt(Payment $payment)
        {
            $payment->load('roomTenant.room.place.owner', 'tenant');

            $ownerContact = optional($payment->roomTenant->room->place->owner)->contact_number ?? '09171234567';

            if ($payment->status === 'unpaid') {
                $receiptUrl = route('owner_mark', ['payment' => $payment->id]);
                $qrCodeSvg = QrCode::format('svg')->size(250)->generate($receiptUrl);

                $payment->update([
                    'status' => 'paid',
                    'paid_date' => now(),
                    'method' => 'cash',
                    'tenant_name'    => $payment->tenant_name,
                    'qr_proof' => $qrCodeSvg,
                    'confirmed_by' => $payment->roomTenant->room->place->owner->id,
                ]);
            }

            $nextDueDate = $payment->due_date->copy()->addMonth();
            $exists = Payment::where('room_tenant_id', $payment->room_tenant_id)
                            ->whereDate('due_date', $nextDueDate)
                            ->exists();

            if (!$exists) {
                Payment::create([
                    'room_tenant_id' => $payment->room_tenant_id,
                    'tenant_name'    => $payment->tenant_name,
                    'tenant_id'      => $payment->tenant_id,
                    'amount'         => $payment->amount,
                    'due_date'       => $nextDueDate,
                    'status'         => 'unpaid',
                    'method'         => 'cash',
                ]);
            }

            return view('owner.payments.receipt', [
                'payment' => $payment->fresh(),
                'ownerContact' => $ownerContact,
            ]);
        }


    public function downloadReceipt(Payment $payment)
    {
        $pdf = Pdf::loadView('owner.payments.receipt', compact('payment'));
        return $pdf->download("receipt_{$payment->id}.pdf");
    }
    public function ownerRequests()
{
    $ownerId = auth()->id();

    $requests = MaintenanceRequest::whereHas('room.place', function ($query) use ($ownerId) {
        $query->where('user_id', $ownerId);
    })->with(['tenant', 'room', 'staff'])->get();

    $staff = Staff::where('owner_id', $ownerId)->get();

     // Group staff by service_type for dropdowns
    $staffGrouped = $staff->groupBy('service_type');

    return view('owner.maintenance.requests', compact('requests', 'staffGrouped','staff'));
}


public function updateMaintenanceRequestStatus(Request $request, $id)
{
    $request->validate([
        'staff_id' => 'required|exists:staffs,id',
    ]);

    $maintenanceRequest = MaintenanceRequest::findOrFail($id);
    $maintenanceRequest->staff_id = $request->staff_id;
    $maintenanceRequest->save();

    return redirect()->back()->with('success', 'Staff successfully assigned!');
}


        public function approve($id)
    {
        $request = MaintenanceRequest::findOrFail($id);

        // Optional: ensure the authenticated user is the owner of the place related to this request
        if (auth()->user()->id !== $request->room->place->owner->id) {
            abort(403, 'Unauthorized');
        }

        $request->status = 'approved';
    
        $request->save();
          if ($request->staff) {
        Mail::to($request->staff->email)->send(new StaffMaintenanceAssigned($request));
    }

        return back()->with('success', 'Maintenance request approved.');
    }

    public function reject($id)
    {
        $request = MaintenanceRequest::findOrFail($id);

        if (auth()->user()->id !== $request->room->place->owner->id) {
            abort(403, 'Unauthorized');
        }

        $request->status = 'rejected';
        $request->save();

        return back()->with('success', 'Maintenance request rejected.');
    }

    public function editRoom($id)
    {   
        $room = Room::findOrFail($id);
        return view('owner.rooms.edit', compact('room'));
    }

    public function updateRoom(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bedspacer,private,shared',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Available,Occupied,Under Maintenance',
            'kitchen_equipment' => 'nullable|string|max:1000',
            'furniture_equipment' => 'nullable|string|max:1000',
            'cctv' => 'sometimes|boolean',
            'laundry_area' => 'sometimes|boolean',
            'allowed_pets' => 'sometimes|boolean',
            'has_wifi' => 'sometimes|boolean',
        ]);

        // Delete selected images
        if ($request->has('delete_images')) {
            foreach ($request->input('delete_images') as $imageId) {
                $image = $room->images()->find($imageId);
                if ($image) {
                    // Delete the file from storage
                    $imagePath = public_path($image->image_path);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }

                    // Delete the DB record
                    $image->delete();
                }
            }
        }

        // Update room data
        $room->update($validated);

        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/room_images'), $filename);

                $room->images()->create([
                    'image_path' => 'images/room_images/' . $filename,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Room updated successfully.');
    }



 public function editPlace($id)
    {   
        $place = Place::findOrFail($id);
        return view('owner.places.edit', compact('place'));
    }

public function updatePlace(Request $request, Place $place)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'location' => 'required|string',
        'type' => 'required|in:apartment,bungalow',
        'image_file' => 'nullable|image|max:5048', // optional on update
    ]);

    // Handle optional image update
    if ($request->hasFile('image_file')) {
        // Delete old image if it exists
        if ($place->image_path && file_exists(public_path($place->image_path))) {
            unlink(public_path($place->image_path));
        }

        $image = $request->file('image_file');
        $imageFilename = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images/place_images'), $imageFilename);
        $validated['image_path'] = 'images/place_images/' . $imageFilename;
    }

    $place->update($validated);

    return redirect()->route('owner')->with('success', 'Place updated successfully.');
}

   public function ownerAnalytics()
{
    $owner = auth()->user();
    $ownerId = $owner->id;

    // Get all payments related to this owner
    $paymentsQuery = Payment::whereHas('roomTenant.room.place', function ($q) use ($ownerId) {
        $q->where('user_id', $ownerId);
    });

    $currentMonth = now()->format('Y-m');

    $monthlyRevenue = (clone $paymentsQuery)
        ->where('status', 'paid')
        ->whereMonth('paid_date', now()->month)
        ->whereYear('paid_date', now()->year)
        ->sum('amount');

    $outstandingDues = (clone $paymentsQuery)
        ->where('status', 'unpaid')
        ->sum('amount');

    $totalDues = (clone $paymentsQuery)->sum('amount');
    $collectionRate = $totalDues > 0 ? round(($monthlyRevenue / $totalDues) * 100, 2) : 0;

    $maintenanceCost = MaintenanceRequest::whereHas('room.place', function ($q) use ($ownerId) {
        $q->where('user_id', $ownerId);
    })->where('status', 'approved')
      ->sum('estimated_cost'); // assuming this column exists

    $tax = 0;
    if ($monthlyRevenue >= 20000) {
        $tax = $monthlyRevenue * 0.05; // 5% tax example
    }

    return view('owner.analytics.analytics', compact(
        'monthlyRevenue',
        'outstandingDues',
        'collectionRate',
        'maintenanceCost',
        'tax'
    ));
}



public function destroyRoom($id)
{
    $room = Room::with(['images', 'roomTenants.tenant'])->findOrFail($id);

    // Delete all images associated with the room
    foreach ($room->images as $image) {
        $path = public_path($image->image_path);
        if (file_exists($path)) {
            unlink($path); // Delete image file from storage
        }
        $image->delete(); // Delete image record
    }

    // Notify and delete all tenants (users) who rented this room
    foreach ($room->roomTenants as $roomTenant) {
        $tenantUser = $roomTenant->tenant;
        if ($tenantUser && $tenantUser->role === 'tenant') {
            // Send termination email
            Mail::to($tenantUser->email)->send(new TenantTerminatedNotification($room, $tenantUser));
            $tenantUser->delete();
        }
        $roomTenant->delete();
    }

    $room->delete(); // Delete the room

    return redirect()->route('owner')->with('success', 'Room, its tenants, and images deleted successfully.');
}


public function destroyPlace($id)
{
    $place = Place::with(['rooms.images', 'rooms.roomTenants.tenant'])->findOrFail($id);

    foreach ($place->rooms as $room) {
        // Delete all images associated with the room
        foreach ($room->images as $image) {
            $path = public_path($image->image_path);
            if (file_exists($path)) {
                unlink($path); // Delete image file from storage
            }
            $image->delete(); // Delete image record
        }

        // Notify and delete all tenants (users) who rented this room
        foreach ($room->roomTenants as $roomTenant) {
            $tenantUser = $roomTenant->tenant;
            if ($tenantUser && $tenantUser->role === 'tenant') {
                // Send termination email
                Mail::to($tenantUser->email)->send(new TenantTerminatedNotification($room, $tenantUser));
                $tenantUser->delete();
            }
            $roomTenant->delete();
        }

        $room->delete(); // Delete room record
    }

    // Optionally delete the place image (if it exists)
    if ($place->image_path) {
        $placeImagePath = public_path($place->image_path);
        if (file_exists($placeImagePath)) {
            unlink($placeImagePath);
        }
    }

    $place->delete(); // Delete the place itself

    return redirect()->route('owner')->with('success', 'Place, its rooms, tenants, and associated images deleted successfully.');
}

    }                                                                                                                   