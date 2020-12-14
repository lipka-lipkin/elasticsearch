<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'name' => $request->name,
            'lang' => $request->lang
        ]);
        return ['status'=>'ok'];
    }

    public function auth(Request $request){

    }
}