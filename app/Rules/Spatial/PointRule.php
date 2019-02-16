<?php

namespace App\Rules\Spatial;

use Illuminate\Contracts\Validation\Rule;

class PointRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     * In geoJSON datatype the first coordinate is lng and second is lat.
     * e.g. {"type": "Point", "coordinates": [102.0, 0.5]}.
     *                                        lng    lat
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!array_key_exists('coordinates', $value)
            || !is_array($value['coordinates'])
            || count($value['coordinates']) != 2
            || !array_key_exists('type', $value)
            || strtolower($value['type']) != 'point') {
            return false;
        }

        return $value['coordinates'][0] > -180
            &&  $value['coordinates'][0] < 180
            &&  $value['coordinates'][1] > -90
            &&  $value['coordinates'][1] < 90;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has invalid data structure.';
    }
}
