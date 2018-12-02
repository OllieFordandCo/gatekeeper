<?php

namespace OllieFordandCo\GateKeeper\Http\Controllers;

use OllieFordandCo\GateKeeper\Http\Controller;
use Illuminate\Support\MessageBag;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin()
    {
        $errors = new MessageBag;
        return view('gatekeeper::auth.login')->with('errors', $errors);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        $errors = new MessageBag;
        return view('gatekeeper::auth.login')->with('errors', $errors);
    }
}