<?php

namespace App\Events;

use App\Models\ProjectAgreement;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AgreementAccepted
{
    use Dispatchable, SerializesModels;

    public ProjectAgreement $agreement;

    public function __construct(ProjectAgreement $agreement)
    {
        $this->agreement = $agreement;
    }
}
