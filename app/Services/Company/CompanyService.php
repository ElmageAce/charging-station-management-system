<?php

namespace App\Services\Company;


use App\Models\Company;
use App\Repositories\CompanyRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CompanyService
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * CompanyService constructor.
     * @param CompanyRepository $companyRepository
     */
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Load companies with pagination.
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return $this->companyRepository->paginate();
    }

    /**
     * Load current company's data.
     *
     * @param Company $company
     * @return Company
     */
    public function show(Company $company)
    {
        return $this->companyRepository->load($company);
    }

    /**
     * Store a new company.
     *
     * @param array $data
     * @return Company
     * @throws \App\Exceptions\RepositoryException
     */
    public function store(array $data)
    {
        return $this->companyRepository->create($data);
    }

    /**
     * Update given company with given data.
     *
     * @param array $data
     * @param Company $company
     * @return Company
     */
    public function update(array $data, Company $company)
    {
        return $this->companyRepository->update($data, $company);
    }

    /**
     * Delete given company.
     *
     * @param Company $company
     * @return bool|null
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        return $this->companyRepository->delete($company);
    }

    /**
     * get paginated subCompanies
     *
     * @param Company $company
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function subCompanyIndex(Company $company)
    {
        return $this->companyRepository->subOf($company)->paginate();
    }
}
