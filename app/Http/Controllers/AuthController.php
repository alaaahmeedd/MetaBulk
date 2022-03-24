<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{

    public function register(Request $request) {
        $fields = $request->validate([

            'name' => 'required|string',
            'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|string',
            'phone' => 'required|string',
   
        ]);
        
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'phone' => $fields['phone'],
            
        ]);
        
        $token = $user->createToken('myapptoken')->plainTextToken;
        $token= substr($token , -40,40);
        User::where('id', $user->id)->update(['api_token' => $token]);
    

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
        
    }
    
    public function login(Request $request){
        
        $fields = $request->validate([
            'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' =>'required|string',
        ]);

        // Check email and Check password
        
        $user = User::where('email' , $fields ['email'])->first();

        $order = Order::select('End_time')->where('user_id',$user->id)->get()->last();
    
        if(Hash::check($fields['password'], $user->password)) {
            
            if($order){
                
            return response()->json(['message'=> $order,
        ]);
            }
            else{
                $test = $request->bearerToken();
                $condition = User::where("api_token", $test)->where("id", $user->id)->first();
                
            // return response()->json(['message'=> $condition]);
            return response()->json(['message'=> "order not found"]);
            
            }        
    }else{
        return response([
            'error' => 'Invalid email or password'
        ], 401);
    }

    // $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            // 'token' => $token
        ];
        return response()->json([$response, 201]);
       


}
}
