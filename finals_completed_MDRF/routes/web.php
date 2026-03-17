<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\Auth\ForgotPasswordController;


// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

//Forgot Password routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Show reset password form
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');

// Handle reset password submission
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

//owner routes
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('owner/dashboard', action: [OwnerController::class, 'index'])->name('owner');
    Route::get('/places/create', [OwnerController::class, 'createPlace'])->name('places.create');
    Route::post('/places/store', [OwnerController::class, 'storePlace'])->name('places.store');
    Route::get('/places', [OwnerController::class, 'showPlace'])->name('places.show');
    Route::get('/rooms/create', [OwnerController::class, 'createRoom'])->name('rooms.create');


    Route::get('/places/{id}/edit', [OwnerController::class, 'editPlace'])->name('places.edit');
    Route::put('/places/{place}', [OwnerController::class, 'updatePlace'])->name('places.update');
    Route::delete('/places/{place}', [OwnerController::class, 'destroyPlace'])->name('owner_places.destroy');



    Route::get('/rooms/{id}/edit', [OwnerController::class, 'editRoom'])->name('rooms.edit');
    Route::put('/rooms/{room}', [OwnerController::class, 'updateRoom'])->name('rooms.update');

    Route::post('/rooms', [OwnerController::class, 'storeRoom'])->name('rooms.store');
    Route::get('/rooms/{id}', [OwnerController::class, 'showRoom'])->name('rooms.show');
    Route::get('/owner/payments/qr/{roomTenantId}', [OwnerController::class, 'showOwnerPaymentPage'])->name('owner.payment.qr');


    Route::get('/owner/payments/{payment}', [OwnerController::class, 'showCashReceipt'])->name('owner_mark');
    Route::get('/owner/payments', [OwnerController::class, 'ownerPayments'])->name('owner.payments');
    Route::get('owner/payment/receipt/{payment}/download', [OwnerController::class, 'downloadReceipt'])->name('owner.payment.download');
    Route::get('/owner/applications', [OwnerController::class, 'listApplications'])->name('owner.applications.index');

    Route::post('/owner/applications/{id}/approve', [OwnerController::class, 'approveApplication'])->name('approve_tenant');
    Route::post('/maintenance/{id}/approve', [OwnerController::class, 'approve'])->name('maintenance.approve');
    Route::post('/maintenance/{id}/reject', [OwnerController::class, 'reject'])->name('maintenance.reject');
    Route::get('/owner/maintenance/requests', [OwnerController::class, 'ownerRequests'])->name('owner.maintenance');
    Route::get('/owner/analytics/analytics', [OwnerController::class, 'ownerAnalytics'])->name('owner.analytics');

   
    Route::post('/owner/maintenance/assign/{id}', [OwnerController::class, 'updateMaintenanceRequestStatus'])
    ->name('maintenance.assign');



        Route::get('/staff', [OwnerController::class, 'indexStaff'])->name('staff.index');
        Route::get('/staff/create', [OwnerController::class, 'createStaff'])->name('staff.create');
        Route::post('/staff/store', [OwnerController::class, 'storeStaff'])->name('staff.store');
        Route::get('/staff/{id}/edit', [OwnerController::class, 'editStaff'])->name('staff.edit');
        Route::put('/staff/{id}/update', [OwnerController::class, 'updateStaff'])->name('staff.update');
        Route::delete('/staff/{id}', [OwnerController::class, 'destroyStaff'])->name('staff.destroy');
                

        Route::post('/owner/terminate/{id}', [OwnerController::class, 'approveTermination'])->name('owner.approveTermination');


    });


//tenant
Route::middleware(['auth', 'role:tenant'])->group(function () {
    Route::get('/tenant/dashboard', [TenantController::class, 'tenantDashboard'])->name('tenant');
    Route::get('tenant/payment', [TenantController::class, 'index'])->name('tenant.payment');
    Route::get('/tenant/payment/{roomTenantId}', [TenantController::class, 'showPaymentPage'])->name('tenant.payment.page');
    Route::post('/tenant/payment/submit', [PaymentController::class, 'store'])->name('tenant.payment.submit');
Route::get('tenant/payment/receipt/{payment}', [TenantController::class, 'showReceipt'])->name('tenant.payment.receipt');
Route::get('tenant/payment/receipt/{payment}/download', [TenantController::class, 'downloadReceipt'])->name('tenant.payment.download');
Route::post('/tenant/payment/gcash', [PaymentController::class, 'submitGcashPayment'])->name('tenant.payment.gcash');
Route::get('/maintenance-requests', [MaintenanceController::class, 'tenantRequests'])->name('maintenance.tenant_requests');
Route::post('/maintenance-requests', [MaintenanceController::class, 'store'])->name('maintenance.requests.store');
Route::put('/maintenance-requests/{id}', [MaintenanceController::class, 'update'])->name('maintenance.requests.update');
Route::delete('/maintenance-requests/{id}', [MaintenanceController::class, 'destroy'])->name('maintenance.requests.destroy');
Route::post('/tenant/termination-request/{id}', [TenantController::class, 'requestTermination'])->name('tenant.requestTermination');


});


// Admin routes 
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'show'])->name('admin');
    Route::get('admin/users/{user}/edit-form', [AdminController::class, 'editForm'])->name('admin.users.editForm');
    Route::post('/admin/users/{user}/edit', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::delete('/admin/applicant/{id}', [AdminController::class, 'applicantdestroy'])->name('admin.applicant.destroy');
    Route::post('/admin/applications/{id}/approve', [AdminController::class, 'approveApplication'])->name('admin.approve');
    Route::get('/admin/owners/{id}', [AdminController::class, 'viewOwner'])->name('admin.owners.view');
    Route::delete('/admin/owners/room/{id}', [AdminController::class, 'destroyRoom'])->name('room.destroy');
    Route::delete('/admin/owners/place/{id}', [AdminController::class, 'destroyPlace'])->name('place.destroy');
    
});

Route::post('/logout', [AdminController::class, 'logout'])->name('logout');



//landowner-aplicant
Route::get('/landowner/application', function () {
    return view('landowner.application');
})->name('landowner.application');
Route::post('/landowner/application', [UserController::class, 'applyLandowner'])->name('landowner.apply');

Route::get('/landowner/activate', function () {
    return view('landowner.activate');
})->name('landowner.activate'); 
Route::post('/landowner/activate', [UserController::class, 'activateLandowner'])->name('landowner.activate');

Route::get('/rooms/{room}/edit', [OwnerController::class, 'edit'])->name('rooms.edit');
Route::delete('/rooms/{room}', [OwnerController::class, 'destroyRoom'])->name('rooms.destroy');


//tenant applicant
Route::get('/applicant/application/{room_id}', function ($room_id) {
    return view('applicant.application', ['room_id' => $room_id]);
})->name('applicant.application');
Route::post('/applicant/application', [UserController::class, 'applyApplicant'])->name('applicant.apply');


Route::get('/applicant/activate', function () {
    return view('applicant.activate');
})->name('applicant.activate'); 
Route::post('/applicant/activate', [UserController::class, 'activateApplicant'])->name('applicant.active');

//activate
Route::post('/activate', [UserController::class, 'activateAccount'])->name('account.activate');


//Homepage
Route::get('/', [HomeController::class, 'index'])->name('homepage.index');
Route::get('/homepage/{id}', [HomeController::class, 'show'])->name('show.homepage');

// logout loadin screen 
Route::get('/logout-loading', [AuthController::class, 'showLoading'])->name('auth.logout_loading');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Default logout

// login expired screen
route::get('/login/expired', function () {return view('auth.expired_login');})->name('auth.expired_login');

// Fallback route
Route::fallback(function () {
    return view('errors/fallback');
})->name('fallback');

// Expired page route
Route::get('/expired_page', function () {
    return view('errors.expired');
})->name('page.expired');

