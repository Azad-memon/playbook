<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function index()
    {
        $pageTitle = "Signup Page";
        return view("web.signup.signup", compact("pageTitle"));
    }
}
