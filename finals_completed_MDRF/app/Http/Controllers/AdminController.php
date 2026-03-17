<?php

namespace App\Http\Controllers;

use App\Models\LandownerApplication;
use App\Models\User;
use App\Models\Place;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\Room;
use App\Models\RoomImage;
use App\Mail\TenantTerminatedNotification;
use App\Mail\ActivationCodeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\TenantAccountTerminated;
use App\Models\RoomTenant;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
public function show(Request $request)
{
    $users = User::with(['application', 'roomTenant'])
        ->when($request->input('name'), fn($query, $name) => $query->where('name', 'like', "%{$name}%"))
        ->when($request->input('email'), fn($query, $email) => $query->where('email', 'like', "%{$email}%"))
        ->when($request->input('role'), fn($query, $role) => $query->where('role', $role))
        ->where('role', '!=', 'admin')
        ->get();

    $roomCount = Room::count();
    $tenantCount = User::where('role', 'tenant')->count();
    $ownerCount = User::where('role', 'owner')->count();

    $applicantCount = LandownerApplication::where('status', 'pending')->count();
    $applicants = LandownerApplication::query()
        ->when($request->input('applicant_name'), fn($query, $name) => $query->where('name', 'like', "%{$name}%"))
        ->when($request->input('applicant_email'), fn($query, $email) => $query->where('email', 'like', "%{$email}%"))
        ->when($request->input('status'), fn($query, $status) => $query->where('status', $status))
        ->whereIn('status', ['pending', 'approved', 'activated'])
        ->get();

    $location = $request->input('location');
    $roomFilter = $request->input('rooms');
    $tenantFilter = $request->input('tenants');

    $ownersQuery = User::with(['places.rooms.roomTenants', 'places.rooms.roomImages'])
        ->where('role', 'owner')
        ->when($location, function ($q) use ($location) {
            $q->whereHas('places', fn($query) => $query->where('location', 'like', "%{$location}%"));
        })
        ->get()
        ->map(function ($owner) {
            $places = $owner->places;
            $rooms = $places->flatMap->rooms;
            $roomCount = 0;
            $tenantCount = 0;

            foreach ($places as $place) {
                foreach ($place->rooms as $room) {
                    $roomCount++;
                    $tenantCount += $room->roomTenants->count();
                }
            }

            $roomImages = $rooms->flatMap->images;

            return [
                'owner' => $owner,
                'owner_place' => $places,
                'owner_room' => $rooms,
                'room_images' => $roomImages,
                'place_count' => $places->count(),
                'room_count' => $roomCount,
                'tenant_count' => $tenantCount,
            ];
        });

    $filteredOwners = $ownersQuery->filter(function ($owner) use ($roomFilter, $tenantFilter) {
        $roomCheck = $roomFilter === null || $owner['room_count'] >= $roomFilter;
        $tenantCheck = $tenantFilter === null || $owner['tenant_count'] >= $tenantFilter;
        return $roomCheck && $tenantCheck;
    });

    $sortedOwners = $filteredOwners->sortBy(function ($owner) use ($roomFilter, $tenantFilter) {
        $priority = 0;
        if ($roomFilter !== null && $owner['room_count'] == $roomFilter) $priority -= 10;
        if ($tenantFilter !== null && $owner['tenant_count'] == $tenantFilter) $priority -= 10;
        return $priority * 1000 - $owner['room_count'] * 10 - $owner['tenant_count'];
    });

    $owners = $sortedOwners->values();

    $locationFilter = request('location');
    $statusFilter = request('status');


    $tenants = User::with(['roomTenant.room.place.owner'])
    ->where('role', 'tenant')
    ->get()
    ->filter(function ($tenant) use ($locationFilter, $statusFilter) {
        $roomTenant = $tenant->roomTenant;
        $room = optional($roomTenant)->room;
        $place = optional($room)->place;

        // Check if the place location matches the filter (case-insensitive)
        $locationMatches = !$locationFilter || ($place && stripos($place->location ?? '', $locationFilter) !== false);

        // Check if roomTenant status matches the filter
        $statusMatches = !$statusFilter || ($roomTenant && $roomTenant->status === $statusFilter);

        return $locationMatches && $statusMatches;
    })
    ->map(function ($tenant) {
        return [
            'tenant' => $tenant,
            'room' => optional($tenant->roomTenant)->room,
            'landlord' => optional(optional($tenant->roomTenant)->room)->place->owner ?? null,
            'roomTenant' => $tenant->roomTenant ?? null,
        ];
    });

    return view('admin.dashboard', compact(
        'users',
        'roomCount',
        'tenantCount',
        'ownerCount',
        'applicantCount',
        'applicants',
        'owners',
        'tenants'
    ));
}

   public function editForm(User $user)
{
    return view('admin.users.edit-form', compact('user'));
}

public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        'role' => 'required|in:owner,tenant,staff',
    ]);

    $user->update($validated);

    return redirect()->route('admin')->with('success', 'User updated successfully.');
}




public function destroy($id)
{
    $user = User::findOrFail($id);

    if ($user->role === 'tenant') {
        // Get the most recent room tenancy record
        $roomTenant = RoomTenant::where('tenant_id', $user->id)
                                ->orderByDesc('created_at')
                                ->first();
            
        if ($roomTenant) {
            if ($roomTenant->end_date && Carbon::parse($roomTenant->end_date)->lte(now())) {
                // Update room status to 'Available'
                $room = Room::find($roomTenant->room_id);
                if ($room) {
                    $room->status = 'Available';
                    $room->save();
                }

                // Send email before deletion
                Mail::to($user->email)->send(new TenantAccountTerminated($user, $roomTenant->end_date));

                // Delete room tenancy record and tenant
                Payment::where('tenant_id', $user->id)->update(['tenant_id' => null]);
                MaintenanceRequest::where('tenant_id', $user->id)->update(['tenant_id' => null]);
                RoomTenant::where('tenant_id', $user->id)->update(['tenant_id' => null]);
                
                $user->delete();

                return redirect()->route('admin')->with('success', 'Tenant deleted successfully and room marked as available.');
            } else {
                $msg = $roomTenant->end_date 
                    ? 'Tenant cannot be deleted because their end date is not yet reached (' . Carbon::parse($roomTenant->end_date)->format('F d, Y h:i A') . ').'
                    : 'Tenant cannot be deleted because no end date has been set.';

                return redirect()->route('admin')->with('error', $msg);
            }
        } else {
            return redirect()->route('admin')->with('error', 'No room tenancy record found for this tenant.');
        }
    }

    if ($user->role === 'owner') {
        // Get all places owned by this owner
        $places = $user->places; // Assuming User hasMany Place relationship

        foreach ($places as $place) {
            foreach ($place->rooms as $room) { // Assuming Place hasMany Room
                // Delete images
                foreach ($room->images as $image) {
                    $path = public_path($image->image_path);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                    $image->delete();
                }

                // Delete room tenants and notify tenants
                foreach ($room->roomTenants as $roomTenant) {
                    $tenantUser = $roomTenant->tenant;
                    if ($tenantUser && $tenantUser->role === 'tenant') {
                        Mail::to($tenantUser->email)->send(new TenantTerminatedNotification($room, $tenantUser));
                        $tenantUser->delete();
                    }
                    $roomTenant->delete();
                }

                $room->delete();
            }

            $place->delete();
        }

        $user->delete();

        return redirect()->route('admin')->with('success', 'Owner and all related places, rooms, tenants, and images have been deleted.');
    }

    // For admin or other roles
    $user->delete();

    return redirect()->route('admin')->with('success', ucfirst($user->role) . ' deleted successfully.');
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

    return redirect()->route('admin')->with('success', 'Room, its tenants, and images deleted successfully.');
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

    return redirect()->route('admin')->with('success', 'Place, its rooms, tenants, and associated images deleted successfully.');
}


public function applicantdestroy($id)
{
    $applicant = LandownerApplication::findOrFail($id);

    // Delete image file if exists
    $imagePath = public_path($applicant->image_path);
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete PDF file if exists
    $pdfPath = public_path($applicant->pdf_path);
    if (file_exists($pdfPath)) {
        unlink($pdfPath);
    }

    // Delete database record
    $applicant->delete();

    return redirect()->route('admin')->with('success', 'User deleted successfully.');
}


    public function listApplications()
    {
        $applications = LandownerApplication::all();
        return view('admin.applications.index', compact('applications'));
    }

    public function approveApplication($id)
    {
        $application = LandownerApplication::findOrFail($id);

        if ($application->status === 'approved') {
            return redirect()->back()->with('info', 'This application is already approved.');
        }

        $activationCode = strtoupper(Str::random(8));
        $application->update([
            'status' => 'approved',
            'activation_code' => $activationCode,
        ]);

       Mail::to($application->email)->send(new ActivationCodeMail($activationCode, $application->name));


        return redirect()->route('admin')->with('success', 'Application approved and activation code sent.');
    }       

    //view owner
    
   public function viewOwner($id)
{
    $owner = User::with('places.rooms')->findOrFail($id);
    return view('admin.view_owner', compact('owner'));
}



    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('success', 'You have been logged out.');
}
}
