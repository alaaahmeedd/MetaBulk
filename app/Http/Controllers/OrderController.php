<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Order::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator   = $request->validate([
            'user_id' => 'required',
            'price' => 'required|integer',
            'Start_time' => 'required|string',
            'End_time' => 'required|string',
            'num_messages' => 'required|integer',
        ]);

        $order = Order::create([
            'user_id' => $validator ['user_id'],
            'price' => $validator ['price'],
            'Start_time' => $validator ['Start_time'],
            'End_time' => $validator ['End_time'],
            'num_messages' => $validator ['num_messages']
    
        ]);

        return $order;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::find($id);

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
        $order = Order::find($id);
        $order->update($request->all());
        return $order;
    }

    public function sub_message(Request $request, $number)
    {
        $user_id =auth('api')->user()->id;

        $messages = Order::select("num_messages")->where("user_id", $user_id)->get()->last();

        $result =  $messages['num_messages'] - $number;

        if($result>=0){

            $status = Order::where("user_id" , $user_id)->get()->last()->update(["num_messages" =>$result]);
            return response(Order::where("user_id" , $user_id)->get()->last() , 200) ;

        }else{
            return response(["none"],500) ;
        }
    }

    public function testget(Request $request){
        // $user = Auth::guard('users')->user();
        $user =auth('api')->user();
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Order::destroy($id);
    }
}
