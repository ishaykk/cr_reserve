<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;

class RoomController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $floors = [1,2,3,4];
        $cap = [4, 6, 8, 10, 12, 14];
        $bool = [1,0];
        return view('rooms.create', compact('floors', 'cap', 'bool'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
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

        return redirect('rooms')->with('success', 'Room added!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function edit($id)
    {

        $floors = [1,2,3,4];
        $cap = [4, 6, 8, 10, 12, 14];
        $bool = [1,0];
        $room = Room::findOrFail($id);
        //dd($room);

        return view('rooms.edit', compact('room', 'floors', 'cap', 'bool'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        Room::findOrFail($id)->update($data);

        return redirect('rooms')->with('success', 'Room updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);
        $room = Room::find($id);
        $room->delete();
        

        return redirect('rooms')->with('success', 'Room '. $id . ' deleted!');
    }


}
