<?php

namespace Tests\Feature\Station;

use App\Models\Station;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseApiTestCase;

class UpdateTest extends BaseApiTestCase
{
    /**
     * A basic Update test.
     *
     * @param Station $station
     * @param array $newData
     * @return void
     * @dataProvider stationDataProvider
     */
    public function testUpdate(Station $station, $newData)
    {
        $newData['location'] = $newData['location']->jsonSerialize()->jsonSerialize();

        $response = $this->json('put', route('api.station.update', $station), $newData);

        $json = $newData;
        $json['id'] = $station->id;

        $response->assertStatus(Response::HTTP_OK)->assertJson($json);

        unset($json['location']);

        $this->assertDatabaseHas('stations', $json);
        $this->assertDatabaseMissing('stations', [
            'id' => $station->id,
            'company_id' => $station->company_id,
            'name' => $station->name,
        ]);
    }

    public function stationDataProvider()
    {
        $this->refreshApplication();

        return [
            [
                factory(Station::class)->state('with-company')->create(),
                factory(Station::class)->make()->toArray()
            ],
            [
                factory(Station::class)->state('with-company')->create(),
                factory(Station::class)->state('with-company')->make()->toArray()
            ],
        ];
    }
}
