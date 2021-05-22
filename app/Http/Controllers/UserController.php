<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        if ($user)
            return view('users.show')->withUser($user);
        else 
            return redirect()->back();
    }

    public function edit($id) 
    {
        if (Auth::user())
        {
            $user = User::findOrFail($id);
            if ($user)
                return view('users.show')->withUser($user);
            else 
                return redirect()->back();
        }
        else
            return redirect()->back();
    }
    public function update($id) 
    {
        if (Auth::user())
        {
            $user = User::findOrFail($id);
            if ($user)
                return view('users.show')->withUser($user);
            else 
                return redirect()->back();
        }
        else
            return redirect()->back();
    }
}
