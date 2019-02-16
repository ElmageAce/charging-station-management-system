<?php

namespace App\Services\Station;


use App\Models\Station;
use App\Repositories\StationRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StationService
{
    /**
     * @var StationRepository
     */
    private $stationRepository;

    /**
     * StationService constructor.
     * @param StationRepository $stationRepository
     */
    public function __construct(StationRepository $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    /**
     * Paginate stations.
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return $this->stationRepository->paginate();
    }

    /**
     * Create new station.
     *
     * @param array $data
     * @return mixed
     * @throws \App\Exceptions\RepositoryException
     */
    public function store(array $data)
    {
        return $this->stationRepository->create($data);
    }

    /**
     * Load the given station's data.
     *
     * @param Station $station
     * @return Station
     */
    public function show(Station $station)
    {
        return $this->stationRepository->load($station);
    }

    /**
     * Update the given station with the given data.
     *
     * @param array $data
     * @param Station $station
     * @return Station
     */
    public function update(array $data, Station $station)
    {
        return $this->stationRepository->update($data, $station);
    }

    /**
     * Delete the given station.
     *
     * @param Station $station
     * @return bool|null
     * @throws \Exception
     */
    public function destroy(Station $station)
    {
        return $this->stationRepository->delete($station);
    }

    public function indexWithinRadius($latitude, $longitude, string $radius)
    {
        $shape = [
            'type' => 'circle', 'radius' => $radius, 'coordinates' => [$longitude, $latitude]
        ];

        return $this->stationRepository->indexWithinRadius($shape);
    }
}
