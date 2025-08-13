<?php

namespace App\Repositories;

use App\Mail\SendEmployeeInvite;
use App\Mail\SendManagerInvite;
use App\Mail\SendSuperAdminInvite;
use App\Models\Company;
use App\Models\Role;
use App\Models\SuperAdminInvite;
use App\Repositories\Interfaces\UserManagementInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class UserManagementRepository implements UserManagementInterface
{

    public function completeSignup($data, $token)
    {
        $invite = SuperAdminInvite::where('token', $token)->firstOrFail();

        if ($invite->accepted_at) {
            return [
                'status' => 'error',
                'message' => 'Invite already used.'
            ];
        }

        // Create the company admin user
        $user = User::create([
            'name'         => $data['name'],
            'phone_number' => $data['phone'] ?? null,
            'email'        => $invite->email,
            'password'     => Hash::make($data['password']),
            'role_id'      => $invite->role_id,
            'company_id'   => $invite->company_id,
        ]);

        // Update company if exists
        $company = Company::find($invite->company_id);
        if ($company) {
            $company->admin_invitation_accepted = 'yes';
            $company->save();
        }

        // Mark invite as accepted
        $invite->update([
            'token'       => null,
            'accepted_at' => now()
        ]);

        return [
            'status'  => 'success',
            'message' => 'Account created. Please log in.',
            'user'    => $user
        ];
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    //COMPANY EMPLOYEES
    public function allCompanyEmployees($company_id)
    {
            $employees = SuperAdminInvite::leftJoin('users', 'super_admin_invites.email', '=', 'users.email')
                ->leftJoin('roles', 'super_admin_invites.role_id', '=', 'roles.id')
                ->where('super_admin_invites.company_id', $company_id)
                ->where('roles.slug', 'employee')
                ->select(
                    'super_admin_invites.*',
                    'users.id as user_id',
                    'users.name as user_name'
                )
                ->get();
            return $employees;
    }
     public function createEmployee(array $data)
    {
        $token = Str::random(60);
        $company = Company::find($data['company_id']);
        $invite = SuperAdminInvite::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'description' => $data['description'],
            'company_id' => $company->id,
            'role_id' => Role::where('slug','employee')->first()->id,
            'logo' => $data['logo'] ?? null,
            'token' => $token,
        ]);

        Mail::to($data['email'])->send(new SendEmployeeInvite($company, $token));

        return $invite;
    }

    public function updateEmployee($id, array $data)
    {
        $invite = SuperAdminInvite::findOrFail($id);
        $invite->update([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'description' => $data['description'] ?? null,
            'logo'        => $data['logo'] ?? $invite->logo,
            // 'token'       => $data['token'] ?? $invite->token,
        ]);

        return $invite;
    }

    public function deleteEmployee($id)
    {
        return SuperAdminInvite::find($id)->delete();
    }


    // COMPANY MANAGERS
    public function allCompanyManagers($company_id)
    {
        $managers = SuperAdminInvite::leftJoin('users', 'super_admin_invites.email', '=', 'users.email')
            ->leftJoin('roles', 'super_admin_invites.role_id', '=', 'roles.id')
            ->where('super_admin_invites.company_id', $company_id)
            ->where('roles.slug', 'manager')
            ->select(
                'super_admin_invites.*',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->get();
        return $managers;
    }
    public function createManager(array $data)
    {
        $token = Str::random(60);
        $company = Company::find($data['company_id']);
        $invite = SuperAdminInvite::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'description' => $data['description'],
            'company_id' => $company->id,
            'role_id' => Role::where('slug','manager')->first()->id,
            'logo' => $data['logo'] ?? null,
            'token' => $token,
        ]);

        Mail::to($data['email'])->send(new SendManagerInvite($company, $token));

        return $invite;
    }

    public function updateManager($id, array $data)
    {
        $invite = SuperAdminInvite::findOrFail($id);
        $invite->update([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'description' => $data['description'] ?? null,
            'logo'        => $data['logo'] ?? $invite->logo,
            // 'token'       => $data['token'] ?? $invite->token,
        ]);

        return $invite;
    }

    public function deleteManager($id)
    {
        return SuperAdminInvite::find($id)->delete();
    }
}
