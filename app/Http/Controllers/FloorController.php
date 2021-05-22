<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Floor;
use App\FloorDrawing;
use App\Room;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $drawings = FloorDrawing::all();
        $floors = Floor::all();
        //dd($floors[1]->drawing->id);
        return view('floors.index', compact('floors', 'drawings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $rooms = Room::all();
        return view('floors.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request) 
    {
        $data = request()->validate([
            'floor_id' => 'required|numeric|unique:floors',
        ]);
        $floor = Floor::firstOrCreate($data);
        if($floor)
            return redirect('floors')->with('success', 'Floor added successfully!');
        return redirect('floors')->with('fail', "Error! Couldn't add floor!");
        }
    /**
        * Display the specified resource.
        *
        * @param  int  $id
        * @return Response
        */
        public function show($id)
        {
            $rooms = Room::pluck('occupied', 'room_id');
            //dd($rooms);
            $floor = Floor::findOrFail($id);
            return view('floors.show', compact('floor', 'rooms'));
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function edit($id)
    {
        $drawings = FloorDrawing::all();
        $floors = Floor::findOrFail($id);
        return view('floors.edit', compact('floors', 'drawings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $floor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $floor)
    {   
        //dd($request['floordrawing_id'], $floor->id);
        $data = $request->validate([
            'floordrawing_id' => 'required',
            
        ]);
        if($data['floordrawing_id'] != '0')
            $floor = Floor::find($floor)->update($data);
        else
            $floor = Floor::find($floor)->update(['floordrawing_id' => null]);
        if($floor)
            return redirect('floors')->with('success', 'Floor drawing has been updated!');
        return redirect('floors')->with('error', "Couldn't update floor drawing");
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
        $floor = Floor::find($id);
        $floor->delete();
        
        return redirect('floors')->with('success', 'Floor '. $id . ' deleted sucessfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMap()
    {
        $floors = Floor::all();
        return view('floors.map', compact('floors'));
    }
}
