<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Configuration;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit() 
    {
        $configs = Configuration::all()->groupBy('section');
        return view('config.edit', compact('configs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $key
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        $niceAttributes = Configuration::pluck('label', 'key')->toArray();
        
        $messages = [
            'date_format' => 'The :attribute format must be date / time format',
          ];
          
        $validator = $this->validate($request, [
            'orders_time_interval' => 'required|date_format:i',
            'min_start_time' => 'required|date_format:H:i',
            'max_start_time' => 'required|date_format:H:i',
            'min_end_time' => 'required|date_format:H:i',
            'max_end_time' => 'required|date_format:H:i',
        ], $messages, $niceAttributes);

        // if $validator is valid update each row in configurations table
        foreach($validator as $key => $val)
        {
            Configuration::where('key', $key)->update(array('value' => $val));
        }

        return redirect('/config')->with('success', 'Configurations has been updated successfully!');
    }
}
