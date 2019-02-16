<?php

namespace App\Http\Controllers\Api\Station;

use App\Http\Controllers\Controller;
use App\Http\Requests\StationRequest;
use App\Models\Station;
use App\Services\Station\StationService;
use App\Tools\JsonResponse;
use App\Tools\Setting;
use Symfony\Component\HttpFoundation\Response;

class StationController extends Controller
{
    /**
     * @var StationService
     */
    private $stationService;

    /**
     * StationController constructor.
     * @param StationService $stationService
     */
    public function __construct(StationService $stationService)
    {

        $this->stationService = $stationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return JsonResponse::successObject($this->stationService->index());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StationRequest $request
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\RepositoryException
     */
    public function store(StationRequest $request)
    {
        return JsonResponse::successObject($this->stationService->store($request->all()), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Station $station
     * @return \Illuminate\Http\Response
     */
    public function show(Station $station)
    {
        return JsonResponse::successObject($this->stationService->show($station));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StationRequest $request
     * @param  \App\Models\Station $station
     * @return \Illuminate\Http\Response
     */
    public function update(StationRequest $request, Station $station)
    {
        return JsonResponse::successObject($this->stationService->update($request->all(), $station));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Station $station
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Station $station)
    {
        $this->stationService->destroy($station);

        return JsonResponse::successMessage(Setting::OBJECT_DELETED);
    }


    public function indexWithinRadius($latitude, $longitude, $radius = '2km')
    {
        return JsonResponse::successObject($this->stationService->indexWithinRadius($latitude, $longitude, $radius));
    }
}
