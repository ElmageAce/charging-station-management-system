<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Services\Company\CompanyService;
use App\Tools\JsonResponse;
use App\Tools\Setting;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * CompanyController constructor.
     * @param CompanyService $companyService
     */
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return JsonResponse::successObject($this->companyService->index());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CompanyRequest $request
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\RepositoryException
     */
    public function store(CompanyRequest $request)
    {
        return JsonResponse::successObject(
            $this->companyService->store($request->all()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return JsonResponse::successObject($this->companyService->show($company));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CompanyRequest $request
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        return JsonResponse::successObject($this->companyService->update($request->all(), $company));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);

        $this->companyService->destroy($company);

        return JsonResponse::successMessage(Setting::OBJECT_DELETED);
    }
}
