<?php

namespace App\Http\Controllers\companyadmin;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SuperAdminInvite;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\UserManagementInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    protected $userRepo;
     public function __construct(UserManagementInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function showSignupForm($token)
    {
        $pageTitle = "Signup Page";
        $invite = SuperAdminInvite::where('token', $token)->firstOrFail();

        if ($invite->accepted_at) {
            return redirect()->route('login')->with('error', 'Invite already used.');
        }

        return view('web.signup.signup', compact('invite','pageTitle','token'));
    }

    public function completeSignup(Request $request, $token)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'password' => 'required|min:8|confirmed',
            'phone'    => 'nullable|string|max:20'
        ]);

        $result = $this->userRepo->completeSignup($request->all(), $token);

        if ($result['status'] === 'error') {
            return redirect()->route('login')->with('error', $result['message']);
        }


        return redirect()->route('login')->with('success', 'Account created. Please log in.');
    }

     // Company Mnaager
     public function companyManagerAddForm($company_id)
    {
        return view('web.panel.companyadmin.manager.partials.add_form',compact('company_id'));
    }
     public function companyManagerEditForm($manager_id)
    {
        $manager = SuperAdminInvite::find($manager_id);
        return view('web.panel.companyadmin.manager.partials.edit_form',compact('manager'));
    }

      // Company Employee
     public function companyEmployeeAddForm($company_id)
    {
        return view('web.panel.companyadmin.employee.partials.add_form',compact('company_id'));
    }
     public function companyEmployeeEditForm($manager_id)
    {
        $manager = SuperAdminInvite::find($manager_id);
        return view('web.panel.companyadmin.employee.partials.edit_form',compact('manager'));
    }

}

