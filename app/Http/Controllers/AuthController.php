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
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|min:3|max:12',
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
            'macAddress'=>'string'
            
        ]);
         
        // Check email and Check password
        // try{
        // }catch (\Exception $e) {
        //     return response(['error' => 'Invalid email or password'], 401);
        // }
        $user = User::where('email' , $fields ['email'])->first();
        // $order = Order::select('End_time')->where('user_id',$user->id)->get()->last();
    
        if($user && Hash::check($fields['password'], $user->password)) {
                $token = $user->createToken('myapptoken')->plainTextToken;
                $token= substr($token , -40,40);
                User::where('id', $user->id)->update(['api_token' => $token]);
                $user = User::where('email' , $fields ['email'])->first();
            // && User::where('signed','=',true)->where('id',$user->id)->exists()
            
            if( User::whereNull('macAddress')->where('id',$user->id)->exists() || User::where('macAddress',$fields['macAddress'])->where('id',$user->id)->exists()) {
                User::where('id', $user->id)->update(['macAddress' => $fields ['macAddress']]);
                return $token;
            }
            return response([ "Unauthorized"], 401);
            // User::where('id', $user->id)->update(['signed' => true]);

            $response = [
            'user' => $user,
            'token' => $token
            ];
            return response($response,200);
                    
        }else{

            return response(['error' => 'Invalid email or password'], 401);
        }

        // $test = $request->bearerToken();
        // $condition = User::where("api_token", $test)->where("id", $user->id)->first();
            
        // return response()->json(['message'=> $condition]);

        // $token = $user->createToken('myapptoken')->plainTextToken;

        // $response = [
        //     'user' => $user,
        //     // 'token' => $token
        // ];
        // return response()->json([$response, 201]);

}
}
