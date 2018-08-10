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

        ]);

          if ($validator->fails()) {

            $messages = $validator->errors();
            $arr = array('status' => 0, 'message' => $messages->first());
            return json_encode($arr);

          } else {

            $name =  $request->input("name");
            $email      =  $request->input("email");
            $password   =  md5($request->input("password"));

            $user = new User;
            $user->name = $name;
            $user->email     = $email;
            $user->password  = $password;

            $user->save();
            
            //We want to give the app the user id back
            $arr = array('status' => 1, 'message' => $user->id);
            return json_encode($arr);
          }
    }

    public function login(Request $request){
        $email = $request->input("email");
        $password = md5($request->input("password"));

        $user = User::where("email", $email)->where("password", $password)->first();

        if($user){
            return ["status" => 1, "message" => $user->id];
        } else {
            //No user found
            return ["status" => 0 ];
        }
    }
}
