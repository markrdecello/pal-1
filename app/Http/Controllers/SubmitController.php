<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\User;
use App\Form;
use App\Questions;
use App\Submitted;
use App\Answers;

class SubmitController extends Controller
{

    public function register($user_id, $form_id){

        $submit = new Submitted;
        $submit->user_id = $user_id;
        $submit->form_id = $form_id;
        $submit->status = 0;

        $submit->save();

        //We want to give the app the user id back
        $arr = array("status" => 1, "message" => $submit->id);
        return json_encode($arr);

    }

    public function submit($id){
        $submit = Submitted::find($id);
        if($submit == null){
           $arr = array("status" => 1, "message" => "form is not open to submission");
           return json_encode($arr);
        }
        $submit->status = 1;
        $submit->save();

        $arr = array("status" => 1, "message" => $submit->id);
        return json_encode($arr);
    }

    public function approve($id){

        $submit = Submitted::find($id)->first();
        if($submit == null){
           $arr = array("status" => 1, "message" => "form is not open to submission");
           return json_encode($arr);
        }

        $status = $submit->status;

        if($status == 1){

            $submit->update(array('status' => 2));

            $arr = array("status" => 1, "message" => "approved");
            return json_encode($arr);
        }
        else{
            $arr = array("status" => 0, "message" => "cant be approved");
            return json_encode($arr);
        }
    }

    //225
    public function resend($id){

        $submit = Submitted::find($id)->first();
        if($submit == null){
           $arr = array("status" => 1, "message" => "form is not open to submission");
           return json_encode($arr);
        }

        $status = $submit->status;

        if($status == 1){

            $submit->update(array('status' => 0));
            Answers::where('submitted_id', $id)->delete();;

            $arr = array("status" => 1, "message" => "resent");
            return json_encode($arr);
        }
        else{
            $arr = array("status" => 0, "message" => "cant be resent");
            return json_encode($arr);
        }

    }

    public function getForm($id){

        $form = Submitted::find($id);
        $form_id = $form->form_id;
        $question_index = Questions::where("form_id", $form_id)->get();
        $answer_index = Answers::where("submitted_id", $id)->latest()->get();
        $forms = Form::find($form_id);
        $data = $question_index->toArray();



        for($x = 0; $x < count($question_index); $x++){
            unset($data[$x]['created_at']);
            unset($data[$x]['updated_at']);

            $questions = $question_index[$x]->question;
            $questions_id = $question_index[$x]->id;

            if($x < count($answer_index)){
                $answers = $answer_index[$x]->answer;
                $answers_id = $answer_index[$x]->question_id;
            }

            if(isset($answers_id)){
                $data[$x]['answer'] = $answers;
            }
            else{
                $data[$x]['answer'] = null;
            }

            $data[$x]['name'] = $forms->name;

        }

        return $data;
    }

    public function status($id){
    	if(Submitted::find($id) == null){
    		return array("status" => "failed", "message" => "this isnt a valid submission");
    	}
    	$form = Submitted::find($id)->first();
    	return array("submission status" => $form->status);
    }

   public function availableForms($id){
        $submit = Submitted::where("user_id", $id)->get();
        if($submit->first() == null){ return array("status" => 0, "message" => "not found"); }
	$index = 0;
	$data = array();

        for($x = 0; $x < count($submit); $x++){
	   if($submit[$x]->status == 0){
	        $form_id = $submit[$x]->form_id;
            	$forms = Form::find($form_id);
            	$data[$index] = array('id' => $submit[$x]['id'], 'name' => $forms['name']);
		$index++;
	    }
        }

        return $data;
    }

    public function counselorForms($id){
    	$users = User::where("counselor_id", $id)->get();
        $data = null;
        $index = 0;
        $set = false;

        for($x = 0; $x < count($users); $x++){
	    $submit = Submitted::where("user_id", $users[$x]->id)->get();
	    for($y = 0; $y < count($submit); $y++){
		   if($submit[$y]->first() == null){ return array("status" => 0, "message" => "not found"); }
		   $form = Form::where("id", $submit[$y]->form_id)->get()->first();

		   if($users[$x]->counselor_id == $id && $submit[$y]->status == 1){
			$data[$index]['id'] = $submit[$y]->id;
			$data[$index]['name'] = $users[$x]->name;
			$data[$index]['form_name'] = $form->name;
			$index++;
		   }
		   else{

		   }

	   }
        }

	$data = array_filter($data);
        return $data;
    }

}