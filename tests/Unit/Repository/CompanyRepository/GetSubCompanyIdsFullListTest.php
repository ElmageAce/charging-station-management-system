<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Repositories\CompanyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GetSubCompanyIdsFullListTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->companyRepository = resolve(CompanyRepository::class);
    }

    /**
     * test getSubCompanyIdsFullList method in CompanyRepository.
     *
     * @return void
     */
    public function testGetSubCompanyIdsFullList()
    {
        $ids = [];

        $junkCompany = factory(Company::class)->create(); // two junk companies
        $junkSubCompany = factory(Company::class)->create(['parent_company_id' => $junkCompany->id]);

        $company = factory(Company::class)->create();
        $ids[] = $company->id;

        $s1companies = factory(Company::class, 2)
            ->create(['parent_company_id' => $company->id])
            ->each(function (Company $company) use (&$ids) {
                $s2companies = factory(Company::class, 2)->create(['parent_company_id' => $company->id]);
                $ids = array_merge($ids, $s2companies->pluck('id')->toArray());
            });
        $ids = array_merge($ids, $s1companies->pluck('id')->toArray());

        $result = $this->companyRepository->getSubCompanyIdsFullList($company);

        foreach ($ids as $id) {
            $this->assertContains($id, $result);
        }

        $this->assertNotContains($junkCompany->id, $result);
        $this->assertNotContains($junkSubCompany->id, $result);

        $this->assertEquals(count($ids), count($result));
    }
}
