<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseApiTestCase;

class UpdateTest extends BaseApiTestCase
{
    /**
     * A basic update test.
     *
     * @param Company $company
     * @param array $newData
     * @return void
     * @dataProvider companyDataProvider
     */
    public function testUpdate(Company $company, $newData)
    {
        $response = $this->json('put', route('api.company.update', $company), $newData);

        $json = $newData;
        $json['id'] = $company->id;

        $response->assertStatus(Response::HTTP_OK)->assertJson($json);

        $this->assertDatabaseHas('companies', $json);
        $this->assertDatabaseMissing('companies', [
            'id' => $company->id,
            'parent_company_id' => $company->parent_company_id,
            'name' => $company->name,
        ]);
    }

    public function companyDataProvider()
    {
        $this->refreshApplication();

        return [
            [
                factory(Company::class)->create(),
                factory(Company::class)->make()->toArray()
            ],
            [
                factory(Company::class)->create(['parent_company_id' => factory(Company::class)->create()->id]),
                factory(Company::class)->make()->toArray()
            ],
            [
                factory(Company::class)->create(),
                factory(Company::class)->make(['parent_company_id' => factory(Company::class)->create()->id])->toArray()
            ],
            [
                factory(Company::class)->create(['parent_company_id' => factory(Company::class)->create()->id]),
                factory(Company::class)->make(['parent_company_id' => factory(Company::class)->create()->id])->toArray()
            ],
            [
                factory(Company::class)->create(),
                ['parent_company_id' => factory(Company::class)->create()->id],
            ],
            [
                factory(Company::class)->create(['parent_company_id' => factory(Company::class)->create()->id]),
                ['parent_company_id' => factory(Company::class)->create()->id],
            ]
        ];
    }
}
