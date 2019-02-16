<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\Company\StationService;

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
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        return $this->stationService->index($company);
    }
}
