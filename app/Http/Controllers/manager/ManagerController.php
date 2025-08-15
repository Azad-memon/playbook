<?php

namespace App\Http\Controllers\manager;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Repositories\Interfaces\UserManagementInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
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
        return view('web.panel.manager.profile.edit', compact('user','breadcrumb','pageTitle'));
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
        $managers = $this->userRepo->allCompanyManagers($company_id);

        $pageTitle = "Managers";
        $breadcrumb = array("active" => "Dashboard", 'home' => route('admin.dashboard'));
        return view('web.panel.companyadmin.manager.index', compact('company_id', 'managers','pageTitle','breadcrumb'));
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
        $this->userRepo->createManager($data);
        return redirect()
            ->route('admin.manager.index')
            ->with('success', 'Manager created and invite sent.');
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

        $this->userRepo->updateManager($id, $data);
        return redirect()
            ->route('admin.manager.index')
            ->with('success', 'Manager updated successfully.');
    }

    public function destroy($id)
    {

        $this->userRepo->deleteManager($id);
        return redirect()
            ->route('admin.manager.index')
            ->with('success', 'Manager deleted successfully.');
    }
}
