<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Company;

class SendEmployeeInvite extends Mailable
{
    use SerializesModels;

    public $company;
    public $token;

    public function __construct(Company $company, $token)
    {
        $this->company = $company;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Complete Your Employee Signup')
                    ->view('web.panel.superadmin.emails.employee_invite')
                    ->with([
                        'signupUrl' => url('/admin/signup/' . $this->token),
                        'companyName' => $this->company->name,
                    ]);
    }
}
