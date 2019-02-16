<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseApiTestCase;

class StoreTest extends BaseApiTestCase
{
    use WithFaker;

    /**
     * A basic store test.
     *
     * @param array $newData
     * @return void
     * @dataProvider companyDataProvider
     */
    public function testStore(array $newData)
    {
        $response = $this->json('post', route('api.company.store'), $newData);

        $json = $newData;

        $response->assertStatus(Response::HTTP_CREATED)->assertJson($json);

        $json['id'] = $response->json('id');

        $this->assertDatabaseHas('companies', $json);
    }

    public function companyDataProvider()
    {
        $this->refreshApplication();

        return [
            [
                factory(Company::class)->make()->toArray()
            ],
            [
                factory(Company::class)->make(['parent_company_id' => factory(Company::class)->create()->id])->toArray()
            ],
        ];
    }

    /**
     * Test store when provided data are invalid.
     *
     * @param array $newData
     * @return void
     * @dataProvider companyDataProvider422
     */
    public function testStore422(array $newData)
    {
        $response = $this->json('post', route('api.company.store'), $newData);

        $json = $newData;

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        if(count($json) > 0) {
            $this->assertDatabaseMissing('companies', $json);
        }
    }

    public function companyDataProvider422()
    {
        $this->refreshApplication();

        return [
            [
                []
            ],
            [
                factory(Company::class)->make(['parent_company_id' => 0])->toArray()
            ],
            [
                ['parent_company_id' => factory(Company::class)->create()->id]
            ],
        ];
    }
}
