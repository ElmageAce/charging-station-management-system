<?php

namespace Tests\Feature\Station;

use App\Models\Company;
use App\Models\Station;
use Tests\BaseApiTestCase;

class ShowTest extends BaseApiTestCase
{
    /**
     * A basic show test.
     *
     * @param Station $station
     * @param Company $company
     * @return void
     * @dataProvider stationDataProvider
     */
    public function testShow(Station $station, Company $company)
    {
        $response = $this->json('get', route('api.station.show', $station));

        $json = $station->toArray();
        $json['location'] = $station->location->jsonSerialize()->jsonSerialize();
        $json['company'] = $company->toArray();

        $response->assertOk()->assertJson($json);
    }

    public function stationDataProvider()
    {
        $this->refreshApplication();

        /** @var Company $company */
        $company = factory(Company::class)->create();
        $station = factory(Station::class)->create(['company_id' => $company->id]);

        return [
            [$station, $company],
        ];
    }
}
