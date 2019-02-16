<?php

namespace Tests\Feature\Station;

use App\Models\Station;
use App\Tools\JsonResponse;
use App\Tools\Setting;
use Tests\BaseApiTestCase;

class DestroyTest extends BaseApiTestCase
{
    /**
     * A basic destroy test.
     *
     * @param Station $station
     * @return void
     * @dataProvider stationDataProvider
     */
    public function testDestroy(Station $station)
    {
        $response = $this->json('delete', route('api.station.destroy', $station));

        $response->assertOk()->assertJson([
            JsonResponse::RESPONSE_DESCRIPTION => Setting::OBJECT_DELETED
        ]);

        $json = $station->toArray();
        unset($json['location']);
        unset($json['company']);

        $this->assertDatabaseMissing('stations', $json);
    }

    public function stationDataProvider()
    {
        $this->refreshApplication();

        return [
            [
                factory(Station::class)->state('with-company')->create(),
            ],
        ];
    }
}
