<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        // Pass the route name to a single loader view
        if ($user->role === 'admin') {
            return view('auth.loading_screen', ['redirectRoute' => route('admin')]);
        } elseif ($user->role === 'owner') {
            return view('auth.loading_screen', ['redirectRoute' => route('owner')]);
        } elseif ($user->role === 'tenant') {
            return view('auth.loading_screen', ['redirectRoute' => route('tenant')]);
        }

        return redirect()->intended('homepage.index');
    }

    return back()->with('error', 'Invalid email or password');
}
     public function showLoading()
    {
        return view('auth.logout_loading'); // Make sure this Blade file exists
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('homepage.index'); // or wherever you want to go after logout
    }
}
