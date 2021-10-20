<?php

namespace App\Http\Controllers;

use Auth;
use App\Room;
use App\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $cap = [4, 6, 8, 10, 12, 14];
        $date = Carbon::now('Israel');
        return view('orders.search', compact('cap', 'date'));
        //return view('orders.search'/*, compact('rooms')*/);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //dd($request);
        $search = $request->get('room_id');
        $rooms = Room::where('room_id', '=', $search)->get();
        //dd($rooms);
        
        return view('orders.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            //'capacity' => 'required',
            'room' => 'required',
            //'date'=> 'required|date_format:d/m/Y',
            'sTime' => 'required|date_format:H:i',
            'eTime' => 'required|date_format:H:i',
        ]);
        if($request->has('projector'))
            $data['projector'] = 1;
        else
            $data['projector'] = 0;
        $data['user_id'] = Auth::id();
        //$data['date'] = \Carbon\Carbon::now('ISRAEL')->format('H:i');

        dd($data);
        Order::create($data);

        return redirect('orders')->with('success', 'Order created successfully!');
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
        //
    }
}
