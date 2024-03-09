<?php

namespace App\Controllers;

class AuthController extends \App\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function status(){

    }

    public function login($api = false){
        $data = auth()->login([
            'email' => request()->get('email'),
            'password' => request()->get('password')
        ]);

        if($data) {

            ($api) ? exit( response()->json(['status'=>'success', 'bearer'=>$data['token']])) : null;

            $message = ['status' => 'success', 'message' => 'Login successful'];
        }else{
            $message = ['status' => 'error', 'message' => 'Login failed'];
        }

        response()->json($message);
    }

    public function register(){
        $data = auth()->register([
            'email' => request()->get('email'),
            'fullname' => request()->get('fullName'),
            'password' => request()->get('password')
        ]);

        if($data) {
            $message = ['status' => 'success', 'message' => 'Registration successful'];
        }else{
            $message = ['status' => 'error', 'message' => 'Registration failed'];
        }

        response()->json($message);
    }

    public function reset(){
        response()->plain('Hey there, were u expecting something 😂');
    }


}
