<?php

namespace Tests\Feature\Company\SubCompanies;

use App\Models\Company;
use App\Tools\Setting;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseApiTestCase;

class IndexTest extends BaseApiTestCase
{
    /**
     * A basic index test.
     *
     * @param Company $company
     * @param Collection $subCompanies
     * @return void
     * @dataProvider stationDataProvider
     */
    public function testIndex($company, $subCompanies)
    {
        $response = $this->json('get', route('api.company.sub-companies.index', [$company->id]));

        $subCompaniesArray = $subCompanies->transform(function (Company $subCompany) use ($company) {
            $subCompany->parent_company = $company->toArray();

            return $subCompany;
        })->take(Setting::PAGE_SIZE)->toArray();

        $response->assertStatus(Response::HTTP_OK)->assertJson([
            'data' => $subCompaniesArray,
            'total' => count($subCompanies),
        ]);
    }

    public function stationDataProvider()
    {
        $this->refreshApplication();

        $generator = function ($numberOfStations = 0) {
            /** @var Company $company */
            $company = factory(Company::class)->create();
            /** @var Collection $stations */
            $subCompanies = factory(Company::class, $numberOfStations)->create(['parent_company_id' => $company->id]);

            return [$company, $subCompanies];
        };

        return [
            $generator(),
            $generator(Setting::PAGE_SIZE - 1),
            $generator(Setting::PAGE_SIZE),
            $generator(Setting::PAGE_SIZE + 1),
            $generator(Setting::PAGE_SIZE * 2),
        ];
    }
}
