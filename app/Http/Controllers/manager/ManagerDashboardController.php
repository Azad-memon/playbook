<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerDashboardController extends Controller
{
    public function index()
    {

        $pageTitle = "Manager Dashboard";
        $breadcrumb = array("active" => "Dashboard", 'home' => route('manager.dashboard'));
        // $breadcrumb['inactive'] = array(
        //     route('admin.dashboard') => "test1",
        //     route('home') => "test2"
        // );


        return view("web.panel.companyadmin.manager.dashboard", compact("pageTitle", "breadcrumb"));
    }
}
