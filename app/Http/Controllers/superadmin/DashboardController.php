<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pageTitle = "Super Admin Dashboard";
        $breadcrumb = array("active" => "Dashboard", 'home' => route('superadmin.dashboard'));
        // $breadcrumb['inactive'] = array(
        //     route('admin.dashboard') => "test1",
        //     route('home') => "test2"
        // );


        return view("web.panel.superadmin.dashboard", compact("pageTitle", "breadcrumb"));
    }
}
