<?php

namespace App\Http\Requests;


use App\Rules\Spatial\PointRule;

class StationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the post request.
     *
     * @param string $prefix
     * @return array
     */
    protected function postRules($prefix = '')
    {
        return [
            'name' => 'required|string|max:255',
            'location' => ['required', new PointRule()],
            'company_id' => 'required|exists:companies,id'
        ];
    }

    protected function putRules()
    {
        $result = parent::putRules();

        $result['company_id'] = 'filled|exists:companies,id';
        $result['location'] = ['filled', new PointRule()];

        return $result;
    }
}
