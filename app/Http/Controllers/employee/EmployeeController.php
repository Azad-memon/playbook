<?php

namespace App\Http\Controllers\employee;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserManagementInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    protected $userRepo;

    public function __construct(UserManagementInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

             // Profile
    public function editProfile()
    {
        $user = auth()->user();
        $pageTitle = "Edit Profile";
        $breadcrumb = array("active" => "Dashboard", 'home' => route('admin.dashboard'));
        return view('web.panel.employee.profile.edit', compact('user','breadcrumb','pageTitle'));
    }

     public function updateProfile(Request $request)
    {
        $user = auth()->user();

            $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'line_manager' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'password' => 'nullable|confirmed|min:6'
        ]);
        // Force email to remain unchanged
        $validated['email'] = $user->email;
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    public function index()
    {

        $user = Auth::user();
        $company_id = $user->company_id;
        $employees = $this->userRepo->allCompanyEmployees($company_id);

        $pageTitle = "Employees";
        $breadcrumb = array("active" => "Dashboard", 'home' => route('admin.dashboard'));
        return view('web.panel.companyadmin.employee.index', compact('company_id', 'employees','pageTitle','breadcrumb'));
    }

    public function store(Request $request)
    {

        $data = $request->all();
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:super_admin_invites',
            'description'   => 'nullable|string',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');

        }
        $this->userRepo->createEmployee($data);
        return redirect()
            ->route('admin.employee.index')
            ->with('success', 'Employee created and invite sent.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:super_admin_invites,email,' . $id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);
        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $this->userRepo->updateEmployee($id, $data);
        return redirect()
            ->route('admin.employee.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {

        $this->userRepo->deleteEmployee($id);
        return redirect()
            ->route('admin.employee.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
