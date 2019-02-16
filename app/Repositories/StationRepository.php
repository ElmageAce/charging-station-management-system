<?php

namespace App\Repositories;


use App\Models\Station;
use App\Tools\Setting;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StationRepository extends BaseRepository
{
    protected $fillable = [
        'name',
        'company_id',
        'location'
    ];

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return Station::class;
    }

    public function load($object)
    {
        if ($object instanceof Station) {
            return $object->load([
                'company',
            ]);
        } elseif ($object instanceof LengthAwarePaginator) {
            $object->getCollection()->transform(function (Station $station) {
                return $station->load(['company']);
            });

            return $object;
        }

        return parent::load($object);
    }

    public function for(array $companyIds)
    {
        $this->query->whereIn('company_id', $companyIds);

        return $this;
    }

    public function fill(array $data, $object, array $fillable = [])
    {
        $object = parent::fill($data, $object, $fillable);

        if (isset($data['location'])) {
            $object->location = new Point($data['location']['coordinates'][1], $data['location']['coordinates'][0]);
        }

        return $object;
    }

    public function indexWithinRadius($shape)
    {
        $builder = Station::search('');

        return $this->load(
            $builder->rule(function ($builder) use ($shape) {
                $rules = [
                    'must' => [
                        [
                            "geo_shape" => [
                                "location" => [
                                    "shape" => $shape,
                                    "relation" => "within",
                                ],
                            ],
                        ]
                    ]
                ];


                return $rules;
            })->paginate(Setting::PAGE_SIZE)
        );
    }
}
