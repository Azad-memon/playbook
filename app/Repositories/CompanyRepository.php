<?php
   namespace App\Repositories;

use App\Models\Company;
use App\Models\SuperAdminInvite;
use App\Models\ModelUsers;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendSuperAdminInvite;
use App\Repositories\Interfaces\CompanyInterface;

class CompanyRepository implements CompanyInterface
{
    public function all()
    {
        return Company::latest()->get();
    }

    public function find($id)
    {
        return Company::findOrFail($id);
    }

    public function createCompanyWithAdmin(array $data)
    {

        $company = Company::create([
            'name' => $data['name'],
            'logo' => $data['logo'] ?? null,
            'email' => $data['company_email'],
            'description' => $data['description'],
        ]);

        $token = Str::random(60);

        SuperAdminInvite::create([
            'company_id' => $company->id,
            'role_id' => Role::where('slug','company-admin')->first()->id,
            'email' => $data['admin_email'],
            'token' => $token,
        ]);

        Mail::to($data['admin_email'])->send(new SendSuperAdminInvite($company, $token));

        return $company;
    }

    public function update($id, array $data)
    {
        $company = Company::findOrFail($id);

        $company->update([
            'name' => $data['name'],
            'email' => $data['company_email'],
            'description' => $data['description'],
            'logo' => $data['logo'] ?? $company->logo,
        ]);

        return $company;
    }

    public function delete($id)
    {
        $company = Company::findOrFail($id);
        return $company->delete();
    }
}

?>
