<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\User;
use Validator;
class LoginController extends Controller
{


    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required',
            'birth_date' => 'nullable',
            'school' => 'nullable',
            'school_id' => 'nullable',
            'grad_year' => 'nullable',
            'gender' => 'nullable',
            'phone_number' => 'nullable',
            'counselor_id' => 'nullable',
        ]);

          if ($validator->fails()) {
            $messages = $validator->errors();
            $arr = array("status" => 0, "message" => $messages->first());

            return json_encode($arr);

          }
          else {

            $name = $request->input("name");
            $email = $request->input("email");
            $password = md5($request->input("password"));
            $birth_date = $request->input("birth_date");
            $school = $request->input("school");
            $school_id = $request->input("school_id");
            $grad_year = $request->input("grad_year");
            $gender = $request->input("gender");
            $phone_number = $request->input("phone_number");
            $counselor_id = $request->input("counselor_id");

            $user = new User;
            $user->name = $name;
            $user->email = $email;
            $user->password = $password;
            $user->birth_date = $birth_date;
            $user->school = $school;
            $user->school_id = $school_id;
            $user->grad_year = $grad_year;
            $user->gender = $gender;
            $user->phone_number = $phone_number;
            $user->counselor_id = $counselor_id;

            $user->save();

            //We want to give the app the user id back
            $arr = array("status" => 1, "message" => $user->id);
            return json_encode($arr);
          }
    }


    public function login(Request $request){
        $email = $request->input("email");
        $password = md5($request->input("password"));

        $user = User::where("email", $email)->where("password", $password)->first();

        if($user){
            return ["status" => 1, "message" => $user->id, "role" => $user->role];
        } else {
            //No user found
            return ["status" => 0, "message" => "Information provided incorrect"];
        }
    }

    public function updateProfile($id, Request $request){

        $user = User::find($id);

        if($user){

            $validator = Validator::make($request->all(), [
                'name' => 'nullable',
                'birth_date' => 'nullable',
                'school' => 'nullable',
                'school_id' => 'nullable',
                'grad_year' => 'nullable',
                'gender' => 'nullable',
                'phone_number' => 'nullable',
                'counselor_id' => 'nullable',
            ]);

            if ($validator->fails()) {
                $messages = $validator->errors();
                $arr = array("status" => 0, "message" => $messages->first());

                return json_encode($arr);

            } else {

                $name = $request->input("name");
                $birth_date = $request->input("birth_date");
                $school = $request->input("school");
                $school_id = $request->input("school_id");
                $grad_year = $request->input("grad_year");
                $gender = $request->input("gender");
                $phone_number = $request->input("phone_number");
                $counselor_id = $request->input("counselor_id");

                    //Im not proud, but im lazy
                if(isset($name)) { $user->name = $name; }
                if(isset($birth_date)) { $user->birth_date = $birth_date; }
                if(isset($school)) { $user->school = $school; }
                if(isset($school_id)) { $user->school_id = $school_id;}
                if(isset($grad_year)) { $user->grad_year = $grad_year;}
                if(isset($gender)) { $user->gender = $gender;}
                if(isset($phone_number)) { $user->phone_number = $phone_number;}
                if(isset($counselor_id)) { $user->counselor_id = $counselor_id;}

                $user->save();

                //We want to give the app the user id back
                $arr = array("status" => 1, "message" => $user->id);
                return json_encode($arr);
            }
        }
        else{
            $arr = array("status" => 0, "message" => "user not found");
            return json_encode($arr);
        }
    }

    public function getProfile($id){
        $user = User::find($id);
        return $user;
    }

    public function getUsersByCounselorID($id){
        
        $users = User::where("counselor_id", $id)->get();
	    $index = 0;
	    $data;

    	for($x = 0; $x < count($users); $x++){
    		if($users[$x]->role == 0){
    		   $data[$index] = $users[$x];
    		   $index++;
    		}
    	}

    	return $data;

    }

    public function getUserWithCounselorID($id){
        
        $users = User::where("counselor_id", $id)->get();
	    $index = 0;
	    $data;

    	for($x = 0; $x < count($users); $x++){
    		if($users[$x]->role > 0){
    		   $data[$index] = $users[$x];
    		   $index++;
    		}
    	}

    	return $data;

    }
}