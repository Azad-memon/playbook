<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $pageTitle = "Employee Dashboard";
        $breadcrumb = array("active" => "Dashboard", 'home' => route('employee.dashboard'));
        // $breadcrumb['inactive'] = array(
        //     route('admin.dashboard') => "test1",
        //     route('home') => "test2"
        // );


        return view("web.panel.companyadmin.employee.dashboard", compact("pageTitle", "breadcrumb"));
    }
}
