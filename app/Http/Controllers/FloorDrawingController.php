<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FloorDrawing;

class FloorDrawingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $res = FloorDrawing::all();
        return view('floordrawings.index', compact('res'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('floordrawings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request) 
    {
        $request['floor_id'] = $request->get('formData')[0]['value'];
        $request['building'] = $request->get('formData')[1]['value'];
        $request['description'] = $request->get('formData')[2]['value'];
        $request['drawing_data'] = $request->get('drawingJsonData');
        //$request['created_by'] = Auth::id();
        //$request['last_update_by'] = Auth::id();
        //return response()->json($request->all());
        //return response()->json($drawingJsonData);
        $data = request()->validate([
            'floor_id' => 'required|numeric',
            'building' => 'required|max:20',
            'description' => 'required|max:255',
            'drawing_data' => 'required|json',
            // 'created_by' => [
            //     'required',
            //     Rule::exists('users')->where(function ($query) {
            //         $query->where('id', Auth::id());
            //     })
            // ],
        ]);
        
        $drawing = FloorDrawing::firstOrCreate($data);
        return response()->json(['url'=>url('/floordrawings')]);
        //return redirect('floordrawings')->with('success', 'Drawing added to database!');
    }

    /**
        * Display the specified resource.
        *
        * @param  int  $id
        * @return Response
        */
        public function show($id)
        {
            //
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function edit($id)
    {
        $drawing = FloorDrawing::findOrFail($id);
        return view('floordrawings.edit', compact('drawing'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FloorDrawing $drawing)
    {   
        //dd($request->all());
        // $validatedData = $request->validate([
        //     'room_id' => [
        //         'required',
        //         'gt:0',
        //         Rule::unique('rooms')->ignore($room),
        //     ],
        //     'floor' => ['required', 'numeric', 'gt:-1',],
        //     'capacity' => ['required', 'numeric', 'gt:0',]
            
        // ]);
        // //dd($validatedData);
        
        // $data['projector'] = ($request->has('projector')) ? 1 : 0;
        // $data['available'] = ($request->has('available')) ? 1 : 0;
        // Room::findOrFail($room->room_id)->update($validatedData);
        // return redirect('rooms')->with('success', 'Room has been updated!');
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
        $drawing = FloorDrawing::find($id);
        $drawing->delete();
        
        return redirect('floordrawings.index')->with('success', 'Drawing '. $id . ' deleted!');
    }
}
