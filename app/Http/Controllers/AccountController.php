<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    public function register(Request $request)
    {
        $this->validate(Input::all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]); // If $this->validate fails Laravel auto redirects you back to the previous route, so no worries here!

        $user = Usuario::create($request);

        Auth::login($user);

        if(Auth::check())
        {
           return response()->json(array('success' => true), 200);
        }
        else
        {
           return response()->json(array('success' => false), 400);
        }
    }

    public function login(Request $request)
    {
        Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        if(Auth::check())
        {
            return response()->json(array('success' => true), 200);
        }
        else
        {
            return response()->json(array('success' => false), 400);
        }
    }

    public function logout()
    {
        if(Auth::logout()){
            return response()->json(array('success' => true), 200);
        }
        else
        {
            return response()->json(array('success' => false), 400);
        }
    }
}
