<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        //dd($user);
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin') || Auth::id() == $user->id)
            {
                //dd($request->all());
                $user_obj = User::findOrFail($user->id);
                if ($user_obj)
                {
                    $data = request()->validate([
                        'name' => [
                            'required',
                            'max:20',
                            'min:3',
                            Rule::unique('users')->ignore($user)
                        ],
                        'email' => [
                            'required',
                            'email',
                            'max: 40',
                            Rule::unique('users')->ignore($user)
                        ]
                    ]);
                    if($data) {
                        $user_obj->update($data);
                        return redirect()->route('users.show', ['user' => $user->id])->with('success', 'User '. $user->id . ' has been updated!');
                    }
                    else
                        return redirect()->route('users.show', ['user' => $user->id])->with("fail', 'User '. $user->id . ' couldn't be updated!");   
                }
            }
        }
        return redirect()->back();
    }
}
