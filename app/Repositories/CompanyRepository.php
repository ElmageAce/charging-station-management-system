<?php

namespace App\Repositories;


use App\Models\Company;
use App\Tools\Setting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyRepository extends BaseRepository
{
    protected $fillable = [
        'name',
        'parent_company_id'
    ];

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return Company::class;
    }

    public function load($object)
    {
        if ($object instanceof Company) {
            return $object->load([
                'parentCompany',
                'subCompanies' => function (HasMany $query) {
                    $query->take(Setting::PAGE_SIZE);
                },
                'stations' => function(HasMany $query) {
                    $query->take(Setting::PAGE_SIZE);
                }
            ]);
        } elseif ($object instanceof LengthAwarePaginator) {
            $object->getCollection()->transform(function (Company $company) {
                return $company->load(['parentCompany']);
            });

            return $object;
        }

        return parent::load($object);
    }

    public function subOf(Company $company)
    {
        $this->query = $company->subCompanies();

        return $this;

    }

    public function getSubCompanyIdsFullList(Company $company)
    {
        $result = [$company->id];
        if($company->subCompanies()->doesntExist()) {
            return $result;
        } else {
            foreach ($company->subCompanies as $subCompany) {
                $result = array_unique(array_merge($result, $this->getSubCompanyIdsFullList($subCompany)));
            }

            return $result;
        }
    }
}
