<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use App\Models\Station;
use App\Tools\JsonResponse;
use App\Tools\Setting;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseApiTestCase;

class DestroyTest extends BaseApiTestCase
{
    /**
     * A basic destroy test.
     *
     * @param Company $company
     * @param array $newData
     * @return void
     * @dataProvider companyDataProvider
     */
    public function testDestroy(Company $company)
    {
        $response = $this->json('delete', route('api.company.destroy', $company));

        $response->assertStatus(Response::HTTP_OK)->assertJson([
            JsonResponse::RESPONSE_DESCRIPTION => Setting::OBJECT_DELETED
        ]);

        $this->assertDatabaseMissing('companies', $company->toArray());
    }

    public function companyDataProvider()
    {
        $this->refreshApplication();

        return [
            [
                factory(Company::class)->create(),
            ],
            [
                factory(Company::class)->create(['parent_company_id' => factory(Company::class)->create()->id]),
            ],
            [
                factory(Company::class)->create(),
            ],
            [
                factory(Company::class)->create(['parent_company_id' => factory(Company::class)->create()->id]),
            ],
            [
                factory(Company::class)->create(),
            ],
            [
                factory(Company::class)->create(['parent_company_id' => factory(Company::class)->create()->id]),
            ]
        ];
    }

    /**
     * Destroy test when company has sub companies or stations.
     *
     * @param Company $company
     * @param array $newData
     * @return void
     * @dataProvider companyDataProvider403
     */
    public function testDestroy403(Company $company)
    {
        $response = $this->json('delete', route('api.company.destroy', $company));

        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('companies', $company->toArray());
    }

    public function companyDataProvider403()
    {
        $this->refreshApplication();

        /** @var Company $companyWithSubCompany */
        $companyWithSubCompany = factory(Company::class)->create();
        factory(Company::class)->create(['parent_company_id' => $companyWithSubCompany->id]);

        /** @var Company $companyWithStation */
        $companyWithStation = factory(Company::class)->create();
        factory(Station::class)->create(['company_id' => $companyWithStation->id]);

        return [
            [
                $companyWithSubCompany,
            ],
            [
                $companyWithStation,
            ],
        ];
    }
}
