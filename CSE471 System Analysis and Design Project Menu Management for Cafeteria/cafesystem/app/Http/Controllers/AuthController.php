<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use Auth;
use Session;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $admin = Admin::where('username', $credentials['username'])
                      ->where('password_hash', $credentials['password'])
                      ->first();

        if ($admin) {
            session(['admin_id' => $admin->id]);
            // Using Auth METHOD For Universal Login -- Fariha
            Auth::guard('admin')->loginUsingId($admin->id);

            return redirect('/dashboard/admin')->with('success', 'Admin login successful!');
        }

        $customer = DB::table('customers')->where('username', $credentials['username'])->first();

        if ($customer && $customer->password === $credentials['password']) {
            session(['customer_id' => $customer->customer_id]);
            // Using Auth METHOD For Universal Login -- Fariha
            Auth::guard('customer')->loginUsingId($customer->customer_id);

            return redirect('/dashboard/user')->with('success', 'Customer login successful!');
        }

        return back()->withInput()->withErrors(['login' => 'Invalid username or password']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:customers,username',
                'email' => 'required|string|email|max:255|unique:customers,email',
                'password' => 'required|string|min:4',
            ]);

            DB::beginTransaction();

            DB::table('customers')->insert([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);

            DB::commit();

            return redirect()->route('login')->with('success', 'Registration successful');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    public function logout()
    {
        session()->forget(['admin_id', 'customer_id']);
        // Using Auth METHOD For Universal Logout -- Fariha
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
        }

        return redirect()->route('login');
    }
}
