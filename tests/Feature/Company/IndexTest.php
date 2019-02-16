<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use App\Tools\Setting;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseApiTestCase;

class IndexTest extends BaseApiTestCase
{
    protected function setUp()
    {
        parent::setUp();

        factory(Company::class, Setting::PAGE_SIZE * 2)->create();
    }

    /**
     * A basic index test.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->json('get', route('api.company.index'));

        $response->assertStatus(Response::HTTP_OK)->assertJsonStructure([
            'total',
            'data' => [
                '*' => [
                    'id',
                    'created_at',
                    'updated_at',
                    'name',
                    'parent_company'
                ]
            ]
        ]);
    }
}
