<?php

namespace App\Http\Controllers;
use App\Models\Archive;
use Carbon\Carbon;
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
            'message_count' => 'required'
           
        ]);

        $user_id =auth('api')->user()->id;
        
        $archive = Archive::create([
            'user_id' => $user_id,
            'names' => $validator ['names'],
            'phones' => $validator ['phones'],
            'message' => $validator ['message'],
            'message_count' => $validator ['message_count'],
            
        ]);


        return response ($archive, 201);
    }

    public function messageToday()
    {
        $archive = Archive::get();
        // foreach($messages as $message){
            return Archive::select('message_count')->whereDate('created_at', '=', Carbon::today())->get();

        }
        
    }
       
       
       
       
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
