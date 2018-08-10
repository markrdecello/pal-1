<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Events\EventMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Chat;
use App\User;
use Validator;

class ChatController extends Controller
{

	public function sendMessage(Request $request){

		$validator = Validator::make($request->all(), [
			"message" => "required",
			"sender" => "required",
			"receiver" => "required",
		]);

		if ($validator->fails()) {
			$messages = $validator->errors();
			$arr = array("status" => 0, "message" => $messages->first());

			return json_encode($arr);
		}
		else{
			
			$chat = new Chat;
			$chat->message = $request->message;
			$chat->sender = $request->sender;
			$chat->receiver = $request->receiver;
			$chat->name = (string)$request->sender.$chat->receiver;
			$chat->save();

			
			event(new EventMessage($chat));
			return $chat;
		}

	}

	public function loadChat($sender, $receiver){
		$chat = Chat::all();
		$index = 0;
		$data[0] = array("status" => 0, "message" => "nothing is found");
		$name =  (string)$sender.$receiver;

		for($x = 0; $x < count($chat); $x++){
			if($chat[$x]->name == $name){
				$data[$index] = $chat[$x];
				$index++;
			}
		}

		return $data;
	}


}