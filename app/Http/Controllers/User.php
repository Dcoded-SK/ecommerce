<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;

class User extends Controller
{
    // this funtion is to create new user

    public function addNewUser(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $insert = new ModelsUser();

        $insert->name = $request['full_name'];
        $insert->email = $request['email'];
        $insert->password = bcrypt($request['password']);

        $insert->role = $request['role'];




        $insert->save();


        return response()->json(['message' => 'Registration successful'], 200);
    }

    // this is for login

    public function login(Request $request)
    {
        // Validate the input
        $request->validate([
            'u_email' => 'required|email|exists:users,email',
            'u_password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->u_email, 'password' => $request->u_password], $remember = true)) {
            // Regenerate session ID
            $request->session()->regenerate();

            // Get authenticated user
            $user = Auth::user();
            $welcomeMessage = "Welcome " . $user->name;

            // Respond based on role
            switch ($user->role) {
                case 'user':
                    $user->assignRole('user');
                    return response()->json([
                        'message' => $welcomeMessage,

                        'redirect' => '/user-home',
                    ]);
                case 'admin':
                    $user->assignRole('admin');

                    return response()->json([
                        'message' => $welcomeMessage,
                        'redirect' => '/admin-home',
                    ]);
                case 'supplier':
                    $user->assignRole('supplier');

                    return response()->json([
                        'message' => $welcomeMessage,
                        'redirect' => '/supplier-home',
                    ]);
            }
        }

        // If login fails, respond with an error
        return response()->json([
            'message' => 'Invalid credentials provided.',
        ], 401);
    }

    public function profile()
    {
        return view("adminFolder.profile");
    }

    public function supplierProfile()
    {
        return view('supplierFolder.profile');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/')->with("error", "You are no more logged in");
    }
}
