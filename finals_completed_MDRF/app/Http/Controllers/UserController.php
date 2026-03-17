<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;  
use App\Models\LandownerApplication;
use App\Models\Applicant;
use App\Models\User;
use App\Models\Room; 
use App\Models\Payment; 
use Illuminate\Support\Facades\DB;
use App\Mail\RoomOccupiedNotification;
use App\Mail\UserRegistrationMail; 

class UserController extends Controller
{
    

    public function showRoom(){

        
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,owner,tenant,staff',
            'contact_number' => 'nullable|string|max:20',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'contact_number' => $validated['contact_number'],
        ]);

       

        // Optionally, you can save the activation code to the database (e.g., in the users table or a separate table)

        Auth::login($user);

        return redirect('/');
    }



    public function applyLandowner(Request $request)
    {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:landowner_applications',
        'password' => 'required|string|min:6',
        'contact_number' => 'nullable|string|max:20',
        'pdf_file' => 'required|mimes:pdf|max:10048',
        'image_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048', 
    ]);

        
    // Handle PDF upload
    $pdf = $request->file('pdf_file');
    $pdfFilename = time() . '_' . $pdf->getClientOriginalName();
    $pdf->move(public_path('pdf/owner_applicant'), $pdfFilename);
    $pdfPath = 'pdf/owner_applicant/' . $pdfFilename;

    // Handle Image upload
    $image = $request->file('image_file');
    $imageFilename = time() . '_' . $image->getClientOriginalName();
    $image->move(public_path('images/user_images'), $imageFilename);
    $imagePath = 'images/user_images/' . $imageFilename;

    $application = LandownerApplication::create([
    'name' => $validated['name'],
    'email' => $validated['email'],
    'password' => Hash::make($validated['password']),
    'contact_number' => $validated['contact_number'],
    'pdf_path' => $pdfPath,
    'image_path' => $imagePath,
    ]);
   
     Mail::to($application->email)->send(new UserRegistrationMail($application->name));
    return redirect()->back()->with('success', 'Your application has been submitted.');
}

public function activateLandowner(Request $request)
{
    $validated = $request->validate([
        'activation_code' => 'required|string',
    ]);
 
    $application = LandownerApplication::where('activation_code', $validated['activation_code'])->first();

    if ($application) {
        $user = User::create([
            'name' => $application->name,
            'email' => $application->email,
            'password' => $application->password, 
            'contact_number' => $application->contact_number, 
            'image_path' => $application->image_path, 
            'role' => 'owner',
        ]);

        // Mark application as activated
        $application->update(['status' => 'activated']);

        Auth::login($user);

        return redirect('/')->with('success', 'Account activated successfully.');
    } else {
        return back()->with('error', 'Invalid activation code.');
    }
}


//tenant
public function applyApplicant(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:6',
        'contact_number' => 'nullable|string|max:20',
        'room_id' => 'required|exists:rooms,id',
        'pdf_file' => 'required|mimes:pdf|max:10048',  // max ~10MB
        'image_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',  // max ~5MB
        'start_date' => 'required|date|after_or_equal:today',
    ]);

    $room = Room::findOrFail($validated['room_id']);

    $monthlyRent = $room->type === 'bedspacer' && $room->capacity > 0
        ? $room->price / $room->capacity
        : $room->price;


            // Handle PDF upload
    $pdf = $request->file('pdf_file');
    $pdfFilename = time() . '_' . $pdf->getClientOriginalName();
    $pdf->move(public_path('pdf/tenant_applicant'), $pdfFilename);
    $pdfPath = 'pdf/tenant_applicant/' . $pdfFilename;

    // Handle Image upload
    $image = $request->file('image_file');
    $imageFilename = time() . '_' . $image->getClientOriginalName();
    $image->move(public_path('images/user_images'), $imageFilename);
    $imagePath = 'images/user_images/' . $imageFilename;

    $application = Applicant::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'contact_number' => $validated['contact_number'],
        'room_id' => $validated['room_id'],
        'start_date' => $validated['start_date'],
        'monthly_rent' => $monthlyRent,
        'pdf_path' => $pdfPath,
        'image_path' => $imagePath,
    ]);

    Mail::to($application->email)->send(new UserRegistrationMail($application->name));

    return redirect()->back()->with('success', 'Your application has been submitted. Please check your email for the activation code.');
}


public function activateApplicant(Request $request)
{
    $validated = $request->validate([
        'activation_code' => 'required|string',
    ]);

    $application = Applicant::where('activation_code', $validated['activation_code'])->first();

    if ($application) {
        // Create tenant user
        $user = User::create([
            'name' => $application->name,
            'email' => $application->email,
            'password' => $application->password,
            'contact_number' => $application->contact_number,
            'image_path' => $application->image_path,
            'role' => 'tenant',
        ]);

        if ($application->room_id) {
            // Insert tenant into room_tenants
            DB::table('room_tenants')->insert([
                'room_id' => $application->room_id,
                'tenant_id' => $user->id,
                'start_date' => $application->start_date,
                'monthly_rent' => $application->monthly_rent,
                'status' => 'renting',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Fetch room_tenant ID
            $roomTenantId = DB::table('room_tenants')
                ->where('tenant_id', $user->id)
                ->where('room_id', $application->room_id)
                ->orderBy('id', 'desc')
                ->value('id');

            // Create initial payment
            Payment::create([
                'room_tenant_id' => $roomTenantId,
                'tenant_id' => $user->id,
                'tenant_name' => $user->name,
                'amount' => $application->monthly_rent,
                'due_date' => $application->start_date,
                'status' => 'unpaid',
            ]);

            // ====================
            // ROOM STATUS LOGIC
            // ====================
            $room = DB::table('rooms')->where('id', $application->room_id)->first();

            if ($room) {
                if (in_array($room->type, ['shared', 'private'])) {
                    // Mark room as occupied
                    DB::table('rooms')->where('id', $room->id)->update([
                        'status' => 'Occupied',
                        'updated_at' => now(),
                    ]);
                } elseif ($room->type === 'bedspacer') {
                    // Count current tenants
                    $tenantCount = DB::table('room_tenants')
                        ->where('room_id', $room->id)
                        ->where('status', 'renting')
                        ->count();

                    if ($tenantCount >= $room->capacity) {
                        // Mark room as occupied
                        DB::table('rooms')->where('id', $room->id)->update([
                            'status' => 'Occupied',
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        // Mark application as activated and log in tenant
        $application->update(['status' => 'activated']);
        Auth::login($user);

        return redirect('/')->with('success', 'Account activated successfully.');
    }

    return back()->with('error', 'Invalid activation code.');
}


public function activateAccount(Request $request)
{
    $validated = $request->validate([
        'activation_code' => 'required|string',
        'type' => 'required|string|in:landowner,applicant',
    ]);

    $type = $validated['type'];

    if ($type === 'landowner') {
        $application = LandownerApplication::where('activation_code', $validated['activation_code'])->first();
        $role = 'owner';
    } elseif ($type === 'applicant') {
        $application = Applicant::where('activation_code', $validated['activation_code'])->first();
        $role = 'tenant';
    } else {
        return back()->with('error', 'Invalid account type.');
    }

    if (!$application) {
        return back()->with('error', 'Invalid activation code.');
    }

    // Check room status before proceeding (for applicants)
    if ($type === 'applicant' && $application->room_id) {
        $room = DB::table('rooms')->where('id', $application->room_id)->first();

        if (!$room) {
            return back()->with('error', 'The assigned room does not exist.');
        }

        // Check if the room is already occupied
        if ($room->status === 'Occupied') {
            return back()->with('error', 'The assigned room is already occupied.');
        }

        // Additional capacity check for bedspacer rooms
        if ($room->type === 'bedspacer') {
            $tenantCount = DB::table('room_tenants')
                ->where('room_id', $room->id)
                ->where('status', 'renting')
                ->count();

            if ($tenantCount >= $room->capacity) {
                return back()->with('error', 'The assigned bedspacer room is already at full capacity.');
            }
        }
    }

    // Create user
    $user = User::create([
        'name' => $application->name,
        'email' => $application->email,
        'password' => $application->password,
        'contact_number' => $application->contact_number,
        'image_path' => $application->image_path,
        'role' => $role,
    ]);

    // Only run this block for applicant/tenant type
    if ($type === 'applicant' && $application->room_id) {
        DB::table('room_tenants')->insert([
            'room_id' => $application->room_id,
            'tenant_id' => $user->id,
            'start_date' => $application->start_date,
            'monthly_rent' => $application->monthly_rent,
            'status' => 'renting',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $roomTenantId = DB::table('room_tenants')
            ->where('tenant_id', $user->id)
            ->where('room_id', $application->room_id)
            ->orderBy('id', 'desc')
            ->value('id');

        Payment::create([
            'room_tenant_id' => $roomTenantId,
            'tenant_id' => $user->id,
            'tenant_name'=> $application->name,
            'confirmed_by' => $user->id, // Assuming the user confirms their own payment
            'amount' => $application->monthly_rent,
            'due_date' => $application->start_date,
            'status' => 'unpaid',
        ]);

        // Update room status after insertion
        if (in_array($room->type, ['shared', 'private'])) {
            DB::table('rooms')->where('id', $room->id)->update([
                'status' => 'Occupied',
                'updated_at' => now(),
            ]);
        // Notify all applicants for this room
            $otherApplicants = Applicant::where('room_id', $room->id)
                ->where('status', '!=', 'activated')
                ->get();

            foreach ($otherApplicants as $applicant) {
                Mail::to($applicant->email)->send(new RoomOccupiedNotification($room, $applicant));
            }

        } elseif ($room->type === 'bedspacer') {
            $tenantCount = DB::table('room_tenants')
                ->where('room_id', $room->id)
                ->where('status', 'renting')
                ->count();

            if ($tenantCount >= $room->capacity) {
                DB::table('rooms')->where('id', $room->id)->update([
                    'status' => 'Occupied',
                    'updated_at' => now(),
                ]);
                $otherApplicants = Applicant::where('room_id', $room->id)
                ->where('status', '!=', 'activated')
                ->get();
                 foreach ($otherApplicants as $applicant) {
                Mail::to($applicant->email)->send(new RoomOccupiedNotification($room, $applicant));
            }
            }
        }
    }

    $application->update(['status' => 'activated']);
    Auth::login($user);

    // Delete all other applicant records with the same email except the activated one
    Applicant::where('email', $application->email)

    ->delete();

    return redirect('/')->with('success', 'Account activated successfully.');
}


}