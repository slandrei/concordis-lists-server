<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dummy;

class ApiDummyController extends Controller
{
    //

    public function createNew(Request $req){
        $input = $req->input();
        [$name, $age] = array_values($input);


        Dummy::updateOrCreate($name, $age);


        return ['success' => true];
    }

    public function index(Request $request){
        return response([
            'success' => 'da da da'
        ]);
    }


    public function postReq(Request $request){
        $toDecode = $request->input();

        return response([
            'post' => 'post request',
            "json" => $toDecode,
            "req" => $request
        ])->header("Access-Control-Allow-Origin", 'http://localhost:19006/');
    }

    public function check(Request $request){
        return response([
            'message' => "Mission passed! :)"
        ]);
    }
}
