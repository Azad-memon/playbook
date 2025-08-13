<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Company;

class SendManagerInvite extends Mailable
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
        return $this->subject('Complete Your Manager Signup')
                    ->view('web.panel.superadmin.emails.manager_invite')
                    ->with([
                        'signupUrl' => url('/admin/signup/' . $this->token),
                        'companyName' => $this->company->name,
                    ]);
    }
}
