<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function get(Request $request){
        $messages = Message::where('to_id', '=', $request->user()->id)->get();
        
        return view('users.messages', ['messages'=>$messages]);
    }

    public function send(Request $request){
        $user = User::find($request->to_id);
        if($user === null){
            abort(404);
        }
        if($request->user()->cannot('send', $user)){
            abort(403);
        }

        $request->validate([
            'content' => ['required']
        ]);

        $message = new Message;
        $message->from_id = $request->user()->id;
        $message->to_id = $request->to_id;
        $message->content = $request->content;

        $message->save();

        return redirect()->route('users.profile', ['id'=>$request->to_id]);
    }

    public function update(Request $request){
        $message = Message::find($request->id);
        if($message === null){
            abort(404);
        }
        if($request->user()->cannot('update', $message)){
            abort(403);
        }

        $request->validate([
            'content' => ['required']
        ]);

        $message->content = $request->content;
        $message->save();

        return redirect()->route('users.profile', ['id'=>$message->to_id]);
    }

    public function delete(Request $request){
        $message = Message::find($request->id);
        if($message === null){
            abort(404);
        }
        if($request->user()->cannot('delete', $message)){
            abort(403);
        }

        $message->delete();
        return redirect()->route('users.profile', ['id'=>$message->to_id]);
    }
}
