<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use App\Models\Station;
use App\Tools\Setting;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseApiTestCase;

class ShowTest extends BaseApiTestCase
{
    /**
     * A basic show test.
     *
     * @param Company $company
     * @return void
     * @dataProvider companyDataProvider
     */
    public function testShow($company)
    {
        $response = $this->json('get', route('api.company.show', $company));

        $json = $company->toArray();
        $json['parent_company'] = null;
        $json['sub_companies'] = [];
        $json['stations'] = [];

        if (!is_null($company->parentCompany)) {
            $json['parent_company'] = $company->parentCompany->toArray();
        }

        if ($company->subCompanies()->exists()) {
            $json['sub_companies'] = $company->subCompanies()->take(Setting::PAGE_SIZE)->get()->toArray();
        }

        if ($company->stations()->exists()) {
            $json['stations'] = $company->stations()->take(Setting::PAGE_SIZE)->get()->transform(function (Station $station) {
                $station->location = $station->location->jsonSerialize()->jsonSerialize();

                return $station;
            })->toArray();
        }

        $response->assertStatus(Response::HTTP_OK)->assertJson($json);
    }

    public function companyDataProvider()
    {
        $this->refreshApplication();
        $company = factory(Company::class)->create();
        $companyWithParent = factory(Company::class)->create(['parent_company_id' => factory(Company::class)->create()->id]);
        $companyWithSub = factory(Company::class)->create();
        factory(Company::class, Setting::PAGE_SIZE * 2)->create(['parent_company_id' => $companyWithSub->id]);

        $companyWithStation = factory(Company::class)->create();
        factory(Station::class, Setting::PAGE_SIZE * 2)->create(['company_id' => $companyWithStation->id]);

        return [
            [$company],
            [$companyWithParent],
            [$companyWithSub],
            [$companyWithStation]
        ];
    }
}
