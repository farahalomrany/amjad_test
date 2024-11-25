<?php
namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $company;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Company $company
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.company.created')
                    ->subject('New Company Created: ' . $this->company->name);
    }
}
