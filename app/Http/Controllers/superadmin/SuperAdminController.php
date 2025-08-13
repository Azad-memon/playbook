<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyInterface;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    protected $companyRepo;

    public function __construct(CompanyInterface $companyRepo)
    {
        $this->companyRepo = $companyRepo;
    }

    // Company
    public function addForm()
    {
        return view('web.panel.superadmin.company.partials.add_form');
    }
   public function editForm($id)
    {
        $company = Company::findOrFail($id);
        return view('web.panel.superadmin.company.partials.edit_form', compact('company'));
    }
    public function index()
    {
        $pageTitle = "Company";
        $breadcrumb = array("active" => "Dashboard", 'home' => route('superadmin.dashboard'));
        $companies = $this->companyRepo->all();
        return view('web.panel.superadmin.company.index', compact('companies','pageTitle','breadcrumb'));
    }

   public function store(Request $request)
    {

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'company_email' => 'required|email|unique:companies,email',
            'admin_email'   => 'required|email|unique:super_admin_invites,email|unique:users,email',
            'description'   => 'nullable|string',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $this->companyRepo->createCompanyWithAdmin($validated);


        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Company created and invite sent to admin.',
            ]);
        }


        return redirect()
            ->route('superadmin.company.index')
            ->with('success', 'Company created and invite sent to admin.');
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'company_email' => 'required|email|unique:companies,email,' . $id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $this->companyRepo->update($id, $data);


        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Company updated successfully.',
            ]);
        }


        return redirect()
            ->route('superadmin.company.index')
            ->with('success', 'Company updated successfull.');
    }

    public function destroy($id)
    {
        $this->companyRepo->delete($id);
        return redirect()
            ->route('superadmin.company.index')
            ->with('success', 'Company deleted successfull.');
    }


}

