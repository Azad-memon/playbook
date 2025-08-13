<?php

namespace App\Http\Controllers\companyadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $pageTitle = "Admin Dashboard";
        $breadcrumb = array("active" => "Dashboard", 'home' => route('admin.dashboard'));
        // $breadcrumb['inactive'] = array(
        //     route('admin.dashboard') => "test1",
        //     route('home') => "test2"
        // );


        return view("web.panel.companyadmin.dashboard", compact("pageTitle", "breadcrumb"));
    }
}
