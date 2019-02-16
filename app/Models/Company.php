<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 * @package App\Models
 *
 * @property integer id
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property string name
 * @property integer parent_company_id
 *
 * @property Collection stations
 * @property Company parentCompany
 * @property Collection subCompanies
 */
class Company extends Model
{
    public function stations() {
        return $this->hasMany('App\Models\Station');
    }

    public function parentCompany() {
        return $this->belongsTo('App\Models\Company', 'parent_company_id', 'id');
    }

    public function subCompanies() {
        return $this->hasMany('App\Models\Company', 'parent_company_id', 'id');
    }
}
