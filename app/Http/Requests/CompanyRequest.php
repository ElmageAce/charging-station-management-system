<?php

namespace App\Http\Requests;


class CompanyRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the post request.
     *
     * @return array
     */
    protected function postRules()
    {
        return [
            'name' => 'required|string|max:255',
            'parent_company_id' => 'nullable|exists:companies,id'
        ];
    }
    /**
     * Get the validation rules that apply to the post request.
     *
     * @return array
     */
    protected function putRules()
    {
        $result = parent::putRules();

        $result['name'] = 'filled|string|max:255';

        return $result;
    }
}
