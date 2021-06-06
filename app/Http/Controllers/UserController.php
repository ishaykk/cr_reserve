<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

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

    public function edit(User $user) 
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin') || Auth::id() == $user->id) {
                $user = User::findOrFail($user->id);
                if ($user) {
                    //dd($user);
                    return view('users.edit')->withUser($user);
                }
            }
        }
        return redirect()->back();
    }
    public function update(Request $request, User $user) 
    {
        //dd($request, $id);
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin') || Auth::id() == $user->id)
            {
                //dd($request->all());
                $user_obj = User::findOrFail($user->id);
                if ($user_obj)
                {
                    $data = request()->validate([
                        'name' => 'required|min:3',
                        'email' => 'required|email',
                    ]);
                    if($data) {
                        $user_obj->update($data);
                        return view('users.show')->withUser($user)->with('success', 'User '. $user->id . ' has been updated!');
                    }
                    else
                        return view('users.show')->withUser($user)->with("fail', 'User '. $user->id . ' couldn't be updated!");   
                }
            }
        }
        return redirect()->back();
    }
}
