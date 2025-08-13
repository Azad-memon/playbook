<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    
    public function index()
    {
        $pageTitle = "Login Page";
        
        return view("web.login.login", compact("pageTitle"));
    }
}
