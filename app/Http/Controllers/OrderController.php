<?php

namespace App\Http\Controllers;

use Auth;
use App\Room;
use App\Order;
use App\User;
use App\Configuration;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
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
        $orders = Order::where('user_id', Auth::id())->get()->sortByDesc('updated_at')->sortByDesc('date');
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for searching available rooms
     * 
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $cap = Room::where('available', 1)->distinct('capacity')->orderBy('capacity', 'asc')->pluck('capacity');
        $date = Carbon::now('Israel');
        $config = Configuration::where('section', 'orders')->pluck('value', 'key');
        return view('orders.search', compact('cap', 'date', 'config'));
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
        $data = request()->validate([
            'capacity' => 'required|integer',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time'
        ]);

        $proj = $request->has('proj') ? 1 : 0;
        $date = $data['date'];
        $dataArray['sTime'] = $data['start_time'];
        $dataArray['eTime'] = $data['end_time'];
        $sDateTime = $data['start_time'];
        $eDateTime = $data['end_time'];
        
        $dataArray['date'] = $date;
        $dataArray['date_il'] = Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
        //dd($sDateTime, $eDateTime);
        $rooms = Room::where('capacity', '>=', $cap)->where('available', 1)->where('projector', '>=', $proj)->whereNotIn('room_id', function($query) use ($date, $eDateTime, $sDateTime) {
            $query->setBindings([$date, $eDateTime, $sDateTime])->select('room_id')->from('orders')->whereRaw('date = ?')->whereRaw('status != 2')->whereRaw('(TIMEDIFF(start_time, ?) < 0 AND TIMEDIFF(end_time, ?) > 0)');
        })->get();
        
        if ($rooms->isEmpty())
            return redirect()->back()->with(['errors' => 'Sorry, no rooms available at this time slot, please try a different time']);
        return view('orders.create', compact('rooms', 'cap', 'dataArray'));   
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

        $dateS = Carbon::parse($request->start_time);
        $dateE = Carbon::parse($request->end_time);

        if($dateE->subHours(5) >= $dateS)
            $data['status'] = 0;
        
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
<<<<<<< HEAD
<<<<<<< Updated upstream
        $order->delete();
        return redirect()->back()->with('success', 'Order deleted successfully!');
=======
        $currentDate = Carbon::now('Israel');
        if(Auth::check() && Auth::user()->hasRole('admin'))
            $order->update(['status' => 3, 'updated_at' => $currentDate]);
        else
            $order->update(['status' => 2, 'updated_at' => $currentDate]);
=======
        $currentDate = Carbon::now('Israel');
        $order->update(['status' => 2, 'updated_at' => $currentDate]);
>>>>>>> 9f544e17b02b27f691f8b1f8c5d4f61d414132e2
        if($order) 
        {
            return redirect()->back()->with('success', 'Order has been canceled successfully!');
        }
        return redirect()->back()->with('errors', "Error! Couldn't cancel your order");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    //public function approve(Order $order)
    //{
        // $order->delete();
        // return redirect()->back()->with('success', 'Order deleted successfully!');
    //}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function deny(Order $order)
    {
        // $order->delete();
        // return redirect()->back()->with('success', 'Order deleted successfully!');
<<<<<<< HEAD
>>>>>>> Stashed changes
=======
>>>>>>> 9f544e17b02b27f691f8b1f8c5d4f61d414132e2
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllOrders()
    {
        $orders = Order::all()->sortByDesc('date')->sortByDesc('updated_at')->sortByDesc('date');
        return view('orders.all', compact('orders'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrdersStats()
    {
        $dateNowIL = Carbon::now()->format('Y-m-d');
        $dateBefore7Days = Carbon::now('Israel')->subDays(30)->format('Y-m-d');

        $last7DaysOrders = Order::whereBetween('date', [$dateBefore7Days, $dateNowIL])->orderBy('room_id')->get(['user_id', 'room_id', 'date', 'start_time', 'end_time']);
        
        $amchartsFormat = [];
        for ($i = 0; $i < count($last7DaysOrders); $i++)
        {
            $amchartsFormat[$i]['roomid'] = strval($last7DaysOrders[$i]['room_id']);
            $date = Carbon::parse($last7DaysOrders[$i]['date'])->toDateString();
            $amchartsFormat[$i]['date'] = $date;
            $amchartsFormat[$i]['fromDate'] = $date. " ". Carbon::parse($last7DaysOrders[$i]['start_time'])->setTimeZone('Israel')->toTimeString();
            $amchartsFormat[$i]['toDate'] = $date. " ". Carbon::parse($last7DaysOrders[$i]['end_time'])->setTimeZone('Israel')->toTimeString();
            $amchartsFormat[$i]['createdBy'] = $last7DaysOrders[$i]->user()->pluck('name')[0];
        }
        $ordersJsonData = json_encode(array_values($amchartsFormat), JSON_PRETTY_PRINT);
        //dd($ordersJsonData);
        
        return view('orders.stats', compact('ordersJsonData'));
    }
}
