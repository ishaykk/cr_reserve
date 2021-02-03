<?php

namespace App\Http\Controllers;

use Auth;
use App\Room;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use \DateTime;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$orders = Order::all()->sortByDesc('date');
        $orders = Order::where('user_id', Auth::id())->get()->sortByDesc('date');
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for searching available rooms
     * 
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //if($request->has('room_id'))
        //    dd($request);
        //$search = $request->get('room_id');
        //$rooms = Room::where('room_id', '=', $search)->get();
        
        //$search = $request->input('room_id');
        //if($request->has('room_id'))
        //    dd($search);
        //dd($orders);
        //$bla = DB::select('room_id', 'order_id')->from('orders')->whereRaw('TIMEDIFF(start_time, "2020-12-09 13:00:00") <= 0 AND TIMEDIFF(end_time, "2020-12-09 12:00:00") >= 0')->get();
        //dd($bla);
        //$cap = [4, 6, 8, 10, 12, 14];
//$cap = Room::select('capacity')->distinct()->get();
        $cap = Room::where('available', '=', 1)->distinct('capacity')->orderBy('capacity', 'asc')->pluck('capacity');
        //dd($cap);
        //$user = Auth::user();
        
        //$rooms = select('room_id')->from('orders')->whereRaw('TIMEDIFF(start_time, "2020-12-09 13:00:00"  <= 0 AND TIMEDIFF(end_time, "2020-12-09 12:00:00") >= 0))')->get();
        $date = Carbon::now('Israel');
        //dd($rooms);
        return view('orders.search', compact('cap', 'date'));
        //return view('orders.search', compact('orders')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
        {
        //dd($request);
        $cap = intval($request->capacity);
        $request->capacity = $cap;
        //dd($request->capacity, $cap);
        $data = request()->validate([
            'capacity' => 'required|integer',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time'
        ]);
        //dd($data);

        $proj = $request->has('proj') ? 1 : 0;
        $date = $request['date'];
        $dataArray['sTime'] = $data['start_time'];
        $dataArray['eTime'] = $data['end_time'];
        $sDateTime = $date. ' '. $data['start_time'];
        $eDateTime = $date. ' '. $data['end_time'];
        $dataArray['date'] = $date;
        $dataArray['date_il'] = Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
        
        //dd($dataArray);
        $rooms = Room::where('capacity', '>=', $cap)->where('projector', '>=', $proj)->whereNotIn('room_id', function($query) use ($eDateTime, $sDateTime) {
            $query->select('room_id')->from('orders')->whereRaw('(TIMEDIFF(start_time, ?) < 0 AND TIMEDIFF(end_time, ?) > 0)')->setBindings([$eDateTime, $sDateTime])->get();
        })->get();
        if ($rooms->isEmpty())
            return redirect('orders/search')->with([compact('rooms', 'cap', 'dataArray'), 'errors' => 'Sorry, no rooms available at this time slot, please try a different time']);
        return view('orders.create', compact('rooms', 'cap', 'dataArray'));
        //dd($rooms);
        //$user = Auth::user();
        //$rooms = Room::all()->pluck('room_id');
        //$date = Carbon::now('Israel');

        $sTime = $request->get('sTime');
        $eTime = $request->get('eTime');
        $carbonSTime = Carbon::parse($request->get('sTime'));
        $carbonETime = Carbon::parse($request->get('eTime'));
        //if($carbonSTime->gte($carbonETime))
        $data = request()->validate([
            'date' => 'required|date',
            'sTime' => 'required',
            'eTime' => 'required|after:sTime'
        ]);
        //$diff = $carbonETime->diffInMinutes($carbonSTime);
        // dd($sTime, $eTime, $diff);
        //$start_date = DateTime::createFromFormat('H:i:s', $request->get('sTime'));
        //$since_start = $start_date->diff(DateTime::createFromFormat('H:i:s', $request->get('eTime')));
        //dd((strtotime($eTime) - strtotime($sTime))/60);
        // $date = $request->get('date');
        // $room_id = $request->get('room');
        // $res = Order::where(function ($query) {
        //     $query->where('date', '=', '2020-11-26')
        //         ->where('room_id', '=', 406);
        // })->get();
        // dd($res);
        // return view('orders.create', compact('res'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // $data = request()->validate([
        //     //'date' => 'required|date',
        //     'start_ime' => 'required',
        //     'end_time' => 'required|after:sTime',
        //     'room_id' => 'required|digits:3'
        // ]);
        $data['date'] = $request->date;
        $data['room_id'] = $request->room_id;
        $data['user_id'] = Auth::id();
        $data['start_time'] = $request->date. ' ' .$request->start_time;
        $data['end_time'] = $request->date. ' ' .$request->end_time;
        $data['status'] = 1;
        //dd($data);
        Order::create($data);

        return redirect('orders')->with('success', 'Order created succesfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect('orders')->with('success', 'Order deleted successfully!');
    }
}
