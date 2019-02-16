<?php

namespace Tests\Feature\Company\Station;

use App\Models\Company;
use App\Models\Station;
use App\Tools\Setting;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseApiTestCase;

class IndexTest extends BaseApiTestCase
{
    /**
     * A basic index test.
     *
     * @param Company $company
     * @param Collection $stations
     * @return void
     * @dataProvider stationDataProvider
     */
    public function testIndex($company, $stations)
    {
        $response = $this->json('get', route('api.company.station.index', [$company->id]));

        $stationsArray = $stations->transform(function (Station $station) use ($company) {
            $station->company = $company->toArray();
            $station->location = $station->location->jsonSerialize()->jsonSerialize();

            return $station;
        })->take(Setting::PAGE_SIZE)->toArray();

        $response->assertStatus(Response::HTTP_OK)->assertJson([
            'data' => $stationsArray,
            'total' => count($stations),
        ]);
    }

    public function stationDataProvider()
    {
        $this->refreshApplication();

        $generator = function ($numberOfStations = 0) {
            /** @var Company $company */
            $company = factory(Company::class)->create();
            /** @var Collection $stations */
            $stations = factory(Station::class, $numberOfStations)->create(['company_id' => $company->id]);

            return [$company, $stations];
        };

        return [
            $generator(),
            $generator(1),
            $generator(Setting::PAGE_SIZE),
            $generator(Setting::PAGE_SIZE + 1),
            $generator(Setting::PAGE_SIZE * 2),
        ];
    }

    /**
     * A test of hierarchy stations.
     */
    public function testIndexInHierarchy()
    {
        $junkCompany = factory(Company::class)->create(); // two junk companies
        $junkSubCompany = factory(Company::class)->create(['parent_company_id' => $junkCompany->id]);

        $company = factory(Company::class)->create();
        $stations[] = factory(Station::class)->create(['company_id' => $company->id]);

         factory(Company::class, 2)
            ->create(['parent_company_id' => $company->id])
            ->each(function (Company $company) use (&$stations) {
                $stations[] = factory(Station::class)->create(['company_id' => $company->id]);
                $s2companies = factory(Company::class, 2)
                    ->create(['parent_company_id' => $company->id])
                    ->each(function (Company $company) use (&$stations) {
                        $stations[] = factory(Station::class)->create(['company_id' => $company->id]);
                    });
            });

        $response = $this->json('get', route('api.company.station.index', [$company->id]));

        $response->assertOk();

        foreach ($stations as $station) {
            $station = $station->toArray();
            $station['location'] = $station['location']->jsonSerialize()->jsonSerialize();
            $response->assertJsonFragment($station);
        }
    }
}
