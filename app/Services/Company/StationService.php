<?php

namespace App\Services\Company;


use App\Models\Company;
use App\Repositories\CompanyRepository;
use App\Repositories\StationRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StationService
{
    /**
     * @var StationRepository
     */
    private $stationRepository;
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * StationService constructor.
     * @param StationRepository $stationRepository
     * @param CompanyRepository $companyRepository
     */
    public function __construct(StationRepository $stationRepository, CompanyRepository $companyRepository)
    {
        $this->stationRepository = $stationRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * Paginate stations.
     *
     * @param Company $company
     * @return LengthAwarePaginator
     */
    public function index(Company $company)
    {
        $subCompanyIds = $this->companyRepository->getSubCompanyIdsFullList($company);

        return $this->stationRepository->for($subCompanyIds)->paginate();
    }
}
