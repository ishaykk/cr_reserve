<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Auth;
use Artisan;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dateNowIL = Carbon::now('Israel')->format('Y-m-d');
        $dateIn7Days = Carbon::now('Israel')->addDays(7)->format('Y-m-d');

        $todayOrders = Order::where('user_id', Auth::user()->id)->where('date', $dateNowIL)->get();
        $next7DaysOrders = Order::where('user_id', Auth::user()->id)->where('date', '>=', $dateNowIL)->where('date', '<=', $dateIn7Days)->get()->sortBy('start_time')->sortBy('date');

        //dd($next7DaysOrders);
        return view('home', compact('todayOrders', 'next7DaysOrders'));
    }

    public function reset() 
    {
        //define('STDIN',fopen("php://stdin","r"));
        //Artisan::call('migrate:fresh', ['--seed' => true]);
        //Artisan::call('migrate:fresh --force');
        Artisan::call('db:seed --force');
        Auth::logout();
        return redirect('/');
    }
}
