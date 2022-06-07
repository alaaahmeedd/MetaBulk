<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
     function upload(Request $request){
        $uploded_files = $request->file->store('public/uploads');

        $file = new File ;
        $file->upload_file = $request->file->hashName();
        $results = $file->save();
        if($results){
        return ["result" => "file added"];
    }
    else{
        return ["result" => "file not added"];

    }
}
}







