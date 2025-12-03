<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProjectAgreement;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectAgreementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project agreement.
     */
    public function view(User $user, ProjectAgreement $projectAgreement): bool
    {
        // User can view if they are either the developer or consumer
        return $user->id === $projectAgreement->developer_id 
            || $user->id === $projectAgreement->consumer_id;
    }

    /**
     * Determine whether the user can update the project agreement.
     */
    public function update(User $user, ProjectAgreement $projectAgreement): bool
    {
        // Only the developer can update the agreement (specifically progress)
        return $user->id === $projectAgreement->developer_id;
    }

    /**
     * Determine whether the user can delete the project agreement.
     */
    public function delete(User $user, ProjectAgreement $projectAgreement): bool
    {
        // Only admins or the consumer who created it can delete
        return $user->role === 'admin' 
            || $user->id === $projectAgreement->consumer_id;
    }
}
