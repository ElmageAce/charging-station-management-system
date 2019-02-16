<?php

namespace Tests\Feature\Station;

use App\Models\Station;
use App\Tools\Setting;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseApiTestCase;

class IndexTest extends BaseApiTestCase
{
    protected function setUp()
    {
        parent::setUp();

        factory(Station::class, Setting::PAGE_SIZE * 2)->state('with-company')->create();
    }

    /**
     * A basic index test.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->json('get', route('api.station.index'));

        $response->assertStatus(Response::HTTP_OK)->assertJsonStructure([
            'total',
            'data' => [
                '*' => [
                    'id',
                    'created_at',
                    'updated_at',
                    'name',
                    'location' => [
                        'type',
                        'coordinates'
                    ],
                    'company' => [
                        'id',
                        'created_at',
                        'updated_at',
                        'name',
                    ]
                ]
            ]
        ]);
    }
}
