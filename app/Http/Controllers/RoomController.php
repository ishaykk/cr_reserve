<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Room;
use App\Floor;
use Exception;

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
        $floors = Floor::all();
        return view('rooms.create', compact('floors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request) 
    {
        $data = request()->validate([
            'room_id' => 'required|unique:rooms|numeric|digits:3',
            'floor' => 'required|numeric|min:0',
            'capacity' => 'required|numeric|min:1'
        ]);

        $data['occupied'] = 0;
        $data['available'] = 1;
        $data['projector'] = ($request->has('projector')) ? 1 : 0;
        $data['available'] = ($request->has('available')) ? 1 : 0;
        
        $room = Room::firstOrCreate($data);
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
        $room = Room::findOrFail($id);
        return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {   
        //dd($request->all());
        $validatedData = $request->validate([
            'room_id' => [
                'required',
                'gt:0',
                Rule::unique('rooms')->ignore($room),
            ],
            'floor' => ['required', 'numeric', 'gt:-1',],
            'capacity' => ['required', 'numeric', 'gt:0',]
            
        ]);
        //dd($validatedData);
        
        $data['projector'] = ($request->has('projector')) ? 1 : 0;
        $data['available'] = ($request->has('available')) ? 1 : 0;
        Room::findOrFail($room->room_id)->update($validatedData);
        return redirect('rooms')->with('success', 'Room has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);,
        $room = Room::find($id);
        $room->delete();
        

        return redirect('rooms')->with('success', 'Room '. $id . ' deleted!');
    }


}
