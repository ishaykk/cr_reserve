<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));

    }

    public function create() {
        $floors = [1,2,3,4];
        $cap = [4, 6, 8, 10, 12, 14];
        $bool = [1,0];
        return view('rooms.create', compact('floors', 'cap', 'bool'));

    }

    public function store(Request $request) 
    {
        $data = request()->validate([
            'room_id' => 'required|digits:3',
            'floor' => 'required',
            'capacity' => 'required',
        ]);
        $data['occupied'] = 0;
        $data['available'] = 1;
        if($request->has('projector'))
            $data['projector'] = 1;
        else
            $data['projector'] = 0;
        //dd($data);
        Room::create($data);

        return redirect('rooms');
    }


}
