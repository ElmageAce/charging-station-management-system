<?php

namespace Tests\Feature\Station;

use App\Models\Company;
use App\Models\Station;
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
     * @param Company $company
     * @return void
     * @dataProvider stationDataProvider
     */
    public function testStore(array $newData, Company $company)
    {
        $response = $this->json('post', route('api.station.store'), $newData);

        $json = $newData;

        $response->assertStatus(Response::HTTP_CREATED)->assertJson($json);

        $json['id'] = $response->json('id');
        $json['company_id'] = $company->id;
        unset($json['location']);

        $this->assertDatabaseHas('stations', $json);
    }

    public function stationDataProvider()
    {
        $this->refreshApplication();

        /** @var Company $company */
        $company = factory(Company::class)->create();

        $newData=factory(Station::class)->make(['company_id' => $company->id])->toArray();
        $newData['location'] = $newData['location']->jsonSerialize()->jsonSerialize();

        return [
            [$newData, $company],
        ];
    }

    /**
     * Test store when provided data are invalid.
     *
     * @param array $newData
     * @return void
     * @dataProvider stationDataProvider422
     */
    public function testStore422(array $newData)
    {
        $response = $this->json('post', route('api.station.store'), $newData);
        $json = $newData;

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        if(count($json) > 0) {
            $this->assertDatabaseMissing('stations', $json);
        }
    }

    public function stationDataProvider422()
    {
        $this->refreshApplication();

        $station = factory(Station::class)->make(['company_id' => 0])->toArray();
        $station['location'] = $station['location']->jsonSerialize()->jsonSerialize();

        return [
            [
                []
            ],
            [
                $station
            ],
            [
                ['company_id' => factory(Company::class)->create()->id]
            ],
        ];
    }
}
