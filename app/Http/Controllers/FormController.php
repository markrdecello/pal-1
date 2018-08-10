<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Questions;
use App\Form;
use Validator;

class FormController extends Controller
{

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'form_type' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $arr = array("status" => 0, "message" => $messages->first());

            return json_encode($arr);
        }
        else {
            $form = new Form;
            $form->name = $request->name;
            $form->form_type = $request->form_type;

            $form->save();

            //We want to give the app the user id back
            $arr = array("status" => 1, "message" => $form->id);
            return json_encode($arr);
        }

    }

    public function getForm($id){
        $questions = Questions::where("form_id", $id)->first();

        if($questions == null){

           	$form = Form::find($id);

	   	$data = $form->toArray();

	    	unset($data['created_at']);
	    	unset($data['updated_at']);

	    	return $data;
        }
        else{
           	$questions = Questions::where("form_id", $id)->get();

		$data = $questions->toArray();

		for($x = 0; $x < count($questions); $x++){
		    unset($data[$x]['created_at']);
		    unset($data[$x]['updated_at']);

		    $questions_form = $questions[$x]->form_id;
		    $questions_id = $questions[$x]->id;

		    unset($data[$x]['id']);
		    unset($data[$x]['form_id']);

		    $data[$x]['id'] = $questions_form;
		    $data[$x]['question_id'] = $questions_id;

		    $ph[$x]['id'] = $data[$x]['id'];
		    $ph[$x]['question_id'] = $data[$x]['question_id'];
		    $ph[$x]['question'] = $data[$x]['question'];

		    $data[$x] = $ph[$x];
		}

		return $data;
        }

    }
}