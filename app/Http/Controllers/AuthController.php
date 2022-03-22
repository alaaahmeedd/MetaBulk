<?php

namespace App\Http\Controllers;
use App\Models\User;
use Dirape\Token\Token;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;



class AuthController extends Controller
{

    public function register(Request $request) {
        $fields = $request->validate([

            'name' => 'required|string',
            'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            // 'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'phone' => 'required|string',
            // 'token_key' => 'string'

        ]);
        

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'phone' => $fields['phone'],
            

      
        ]);
        
     
        $token = $user->createToken('myapptoken')->plainTextToken;
        User::where('id', $user->id)->update(['api_token' => $token]);
        PersonalAccessToken::where('id',$user->id)->update(['token'=>$token]);

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);


        // return response([$user], 201);
    }
    
    public function login(Request $request){
        
        $fields = $request->validate([
            
            'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            // 'email' =>'required|email',
            'password' =>'required|string',
            // 'password' =>'required|string|confirmed'
        ]);

        // Check email and Check password
        // $user = User::where('email', $fields['email'])->first();
        $user = User::where('email' , $fields ['email'])->first();

        $set = PersonalAccessToken::where('tokenable_id', $user->id)->first();

        // if($user->api_token == $set->)
        
        $order = Order::select('End_time')->where('user_id',$user->id)->get()->last();


        
        
        // $set = User::select('email')->where('email' , $->get();
        
        
        if(Hash::check($fields['password'], $user->password)) {
            
            if($order){
                
            return response()->json(['message'=> $order,
        ]);
            }
            else{
                
            return response()->json(['message'=> "order not found"]);
            }
        
    }else{
        return response([
            'error' => 'Invalid email or password'
        ], 401);
    }

    $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response()->json([$response, 201]);
       


}
}
