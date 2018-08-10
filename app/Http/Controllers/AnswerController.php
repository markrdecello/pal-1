<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Answers;

use Validator;


class AnswerController extends Controller
{

    public function register($question_id, $submitted_id, Request $request){

        $validator = Validator::make($request->all(), [
            'answer' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $arr = array("status" => 0, "message" => $messages->first());

            return json_encode($arr);
        }
        else {


	#Remove this if statment, to have records in DB
	#if(Answers::where("question_id", $question_id)->first() != null){
	#    $arr = array("status" => 0, "message" => "This question was already answered");

        #    return json_encode($arr);
	#}

            $answer = new Answers;
            $answer->question_id = $question_id;
            $answer->submitted_id = $submitted_id;
            $answer->answer = $request->answer;

            $answer->save();

            //We want to give the app the user id back
            $arr = array("status" => 1, "message" => $answer->id);
            return json_encode($arr);
          }
    }

}