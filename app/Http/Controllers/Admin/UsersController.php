<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Validation\Rule;
use App\User;
use App\Role;

use Auth;
use Gate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function _construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('index-users'))
            return redirect()->back();
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Gate::denies('edit-users')) 
            return redirect(('admin.users.index'));

        $roles = Role::all();
        return view('admin.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //dd($user);
        if (!$request->roles)
            return redirect()->back()->with('error', 'User has to have at least one role!');
        $data = request()->validate([
            'name' => [
                'required',
                'max:20',
                Rule::unique('users')->ignore($user),
            ],
            'email' => [
                'required',
                Rule::unique('users')->ignore($user),
            ]
        ]);
        
        $user->update($data);

        $user->roles()->sync($request->roles);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->id == Auth::id())
            return redirect()->back()->with('error', 'Deleting admin account isnt allowed!!!');
        $user->roles()->detach();
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
