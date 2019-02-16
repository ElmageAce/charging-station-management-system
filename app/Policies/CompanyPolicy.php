<?php

namespace App\Policies;

use App\Models\Company;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given company can be deleted.
     *
     * @param User|null $user
     * @param Company $company
     * @return bool
     */
    public function delete(?User $user, Company $company)
    {
        return $company->subCompanies()->doesntExist() && $company->stations()->doesntExist();
    }
}
