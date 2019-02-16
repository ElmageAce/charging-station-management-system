<?php

namespace Tests\Feature\Company;

use App\Models\Station;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseApiTestCase;

class WithinRadiusTest extends BaseApiTestCase
{
    // bushwickAve and queens are less than 2km far from each other
    const bushwickAve = ['lat' => 40.693513, 'lng' => -73.899730];
    const queens = ['lat' => 40.7038006, 'lng' => -73.9168892];

    //manhattan is about 9 km far away.
    const manhattan = ['lat' => 40.710855, 'lng' => -74.006838];


    /**
     * A test to filter station by a circle.
     *
     * @param Station $station
     * @param array $region
     * @param string $radius
     * @param bool $missing
     * @return void
     * @dataProvider stationDataProvider
     */
    public function testWithinRadius(Station $station, array $region, string $radius, bool $missing = false)
    {
        // make sure that the newly created station is searchable then proceed into the test.
        $station->searchable();
        sleep(2);

        $queryString = [
            'latitude' => $region['lat'],
            'longitude' => $region['lng'],
        ];

        if ($radius !== 'NA') {
            $queryString['radius'] = $radius;
        }

        $response = $this->json('get', route('api.station.index-within-radius', $queryString));

        $json = $station->toArray();
        $json['location'] = $station->location->jsonSerialize()->jsonSerialize();

        if($missing) {
            $response->assertStatus(Response::HTTP_OK)
                ->assertJsonMissingExact($json)
                ->assertJsonStructure([
                    'total',
                    'from',
                    'to',
                    'data'
                ]);
        } else {
            $response->assertStatus(Response::HTTP_OK)->assertJsonFragment($json)->assertJsonStructure([
                'total',
                'from',
                'to',
                'data' => [
                    '*' => [
                        'id',
                        'created_at',
                        'updated_at',
                        'name',
                        'company' => [
                            'id',
                            'created_at',
                            'updated_at',
                            'name',
                        ],
                        'location' => [
                            'type',
                            'coordinates'
                        ]
                    ]
                ]
            ]);
        }

        $station->unsearchable();
    }

    public function stationDataProvider()
    {
        $this->refreshApplication();

        $result =  [
            [
                factory(Station::class)->state('with-company')->create([
                    'location' => new Point(self::bushwickAve['lat'], self::bushwickAve['lng'])
                ]),
                self::queens,
                'NA'
            ],
            [
                factory(Station::class)->state('with-company')->create([
                    'location' => new Point(self::queens['lat'], self::queens['lng'])
                ]),
                self::queens,
                'NA'
            ],
            [
                factory(Station::class)->state('with-company')->create([
                    'location' => new Point(self::queens['lat'], self::queens['lng'])
                ]),
                self::bushwickAve,
                'NA'
            ],
            [
                factory(Station::class)->state('with-company')->create([
                    'location' => new Point(self::queens['lat'], self::queens['lng'])
                ]),
                self::manhattan,
                '10km'
            ],
            [
                factory(Station::class)->state('with-company')->create([
                    'location' => new Point(self::manhattan['lat'], self::manhattan['lng'])
                ]),
                self::queens,
                '10km'
            ],
            [
                factory(Station::class)->state('with-company')->create([
                    'location' => new Point(self::queens['lat'], self::queens['lng'])
                ]),
                self::manhattan,
                'NA',
                true
            ],
            [
                factory(Station::class)->state('with-company')->create([
                    'location' => new Point(self::manhattan['lat'], self::manhattan['lng'])
                ]),
                self::queens,
                'NA',
                true
            ],
            [
                factory(Station::class)->state('with-company')->create([
                    'location' => new Point(self::queens['lat'], self::queens['lng'])
                ]),
                self::manhattan,
                '2km',
                true
            ],
            [
                factory(Station::class)->state('with-company')->create([
                    'location' => new Point(self::manhattan['lat'], self::manhattan['lng'])
                ]),
                self::queens,
                '2km',
                true
            ],
        ];

        return $result;
    }
}
