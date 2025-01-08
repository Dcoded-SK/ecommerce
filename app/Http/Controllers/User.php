<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Illuminate\Http\Request;

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
}
