<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PusherController extends Controller
{
    public function index(){



        return view('RH.chat.index');

    }
    public function broadcast(Request $request){

        broadcast(new PusherBroadcast($request->get('message')))->toOthers();

        return view('RH.chat.broadcast',['message'=>$request->get('message')]);
        
    }
    public function receive(Request $request){
        



        return view('RH.chat.receive',['message'=>$request->get('message')]);
    }
}
