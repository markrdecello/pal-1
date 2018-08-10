<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Questions;
use App\Form;
use Validator;
class QuestionController extends Controller
{

    public function register($id, Request $request){
        
        $form = Form::find($id);

        if($form){
            $validator = Validator::make($request->all(), [
                "question" => "required",
            ]);

            if ($validator->fails()) {
                $messages = $validator->errors();
                $arr = array("status" => 0, "message" => $messages->first());
                
                return json_encode($arr);
            } 
            else {
                $question = new Questions;
                $question->question = $request->question;
                $question->form_id = $id;

                $question->save();
                
                //We want to give the app the user id back
                $arr = array("status" => 1, "message" => $question->id);
                return json_encode($arr);
            }
        }
        else{
            $arr = array("status" => 0, "message" => "form not found");
            return json_encode($arr);
        }
    }
}
