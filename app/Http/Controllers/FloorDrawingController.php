<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\FloorDrawing;
use App\Room;
use App\Floor;
use Auth;

class FloorDrawingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $drawings = FloorDrawing::all();
        return view('floordrawings.index', compact('drawings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $floors = Floor::all();
        $uniqueFloors = array_unique(Room::all()->pluck('floor')->toArray());
        //dd($floors);
        $rooms = Room::all();
        return view('floordrawings.create', compact('rooms', 'floors', 'uniqueFloors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request) 
    {
        $data['floor_id'] = $request->get('formData')[0]['value'];
        $data['building'] = $request->get('formData')[1]['value'];
        $data['description'] = $request->get('formData')[2]['value'];
        $data['drawing_data'] = $request->get('drawingJsonData');
        //$data = $request->get('formData');
        $data['created_by'] = $data['last_update_by'] = Auth::id();
        //return response()->json($request->all());
        //return response()->json($drawingJsonData);
        // $data = request()->validate([
        //     'floor_id' => 'required|numeric',
        //     'building' => 'required|max:20',
        //     'description' => 'max:255',
        //     'drawing_data' => 'required|json',
            // 'created_by' => [
            //     'required',
            //     Rule::exists('users')->where(function ($query) {
            //         $query->where('id', Auth::id());
            //     })
            // ],
        //]);
        //$data = ['data'=> $request->get('formData')];
        //$data2 = json_decode($request->get('formData'), true);
        $validator = validator::make($data, [
            'floor_id' => 'required|numeric',
            'building' => 'required|max:20',
            'description' => 'max:255',
            'drawing_data' => 'required|json',
        ]);

        if ($validator->fails()) 
        {
            if($request->ajax())
            {
                return response()->json(array(
                    'success' => false,
                    'message' => 'There are incorect values in the form!',
                    'errors' => $validator->getMessageBag()->toArray()
                ), 422);
            }
            $this->throwValidationException(
                $request, $validator
            );
        }
        
        $drawing = FloorDrawing::firstOrCreate($data);
        //return response()->json(['url'=>url('/floordrawings')]);
        //return redirect('floordrawings')->with('success', 'Drawing added to database!');
        //return response()->json(['success' => 'Drawing has benn added to database successfully!']);
        return response()->json(['data' => $validator]);
    }
    /**
        * Display the specified resource.
        *
        * @param  int  $id
        * @return Response
        */
        public function show($id)
        {
            //$rooms = Room::pluck('occupied', 'room_id');
            //dd($rooms);
            $drawing = FloorDrawing::findOrFail($id);
            //dump(response()->json($drawing->drawing_data));
            return view('floordrawings.show', compact('drawing'/*, 'rooms'*/));
            //return response()->json($drawing->drawing_data);    
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
        
        return redirect('floordrawings')->with('success', 'Drawing '. $id . ' deleted!');
    }

    /**
     * Retrieve the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDrawing(Request $request)
    {
        $drawing = FloorDrawing::findOrFail($request->drawingId);
        return response()->json($drawing->drawing_data);       
    }
}
