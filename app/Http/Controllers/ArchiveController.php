<?php

namespace App\Http\Controllers;
use App\Models\Archive;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Archive::all();
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'names' => 'required',
            'phones' => 'required',
            'message' => 'required',
            'message_count' => 'required',

           
        ]);
        // $user_id = optional(Auth::user())->id;
        $user_id =auth('api')->user()->id;
        $message_count_today = Archive::where('user_id',$user_id)->whereDate('created_at', '=', Carbon::today())->sum('message_count');
        $message_count_month =Archive::where('user_id',$user_id)->whereMonth('created_at', Carbon::now()->month)->get()->sum('message_count');
       

        if($message_count_today + $validator["message_count"] <= 500 and $message_count_month + $validator["message_count"] <=4500){
        
        $archive = Archive::create([
            'user_id' => $user_id,
            'names' => $validator ['names'],
            'phones' => $validator ['phones'],
            'message' => $validator ['message'],
            'message_count' => $validator ['message_count'],
            
        ]);
        
        return response ($archive, 201);
    }
    return response ('error',401);

   

}




    public function messageToday()
    {
        return  Archive::where('user_id',3)->whereDate('created_at', '=', Carbon::today())->sum('message_count');
        // if($archive>500){
        //    return Archive::create([
        //         'user_id' => 3,
        //         'names' => 0,
        //         'phones' => 0,
        //         'message' => 0,
        //         'message_count' => '1',
               
        //     ]);
         
    // }
    // return response (404);
    }



        // return Archive::select('message_count')->where('user_id' , 3)->whereDate('created_at', '=', Carbon::today())->count();

        
        
    
       
       
       
       
        // $archive = Archive::create([
        //     'user_id' => $request['user_id'],
        //     'names' => $request['names'],
        //     'phones' => $request['phones'],
        //     'message' => $request['message']
        //     //  'names'=>$request['names']
            
        // ]);

        // return response($archive, 201);
        // return gettype($request['names']);
      
        //  Archive::create([
        //      'names'=>$request['names']
        //  ]);
        
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Archive::find($id);
        
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
        $archive = Archive::find($id);
        return $archive;
        // $archive->update($request->all());
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Archive::destroy($id);
        
    }
}
