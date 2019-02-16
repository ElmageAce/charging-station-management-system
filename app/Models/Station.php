<?php

namespace App\Models;

use App\Elastic\Configurators\StationConfigurator;
use Carbon\Carbon;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;

/**
 * Class Station
 * @package App\Models
 *
 * @property integer id
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property string name
 * @property Point location
 * @property integer company_id
 *
 * @property Company company
 */
class Station extends Model
{
    use SpatialTrait, Searchable;

    protected $spatialFields = ['location'];

    protected $indexConfigurator = StationConfigurator::class;

    public function company() {
        return $this->belongsTo('App\Models\Company');
    }

    ///////////////////////////////////////////
    ///             SEARCHABLE              ///
    ///////////////////////////////////////////

    public function toSearchableArray()
    {
        $this->refresh();

        $result = $this->load(['company'])->toArray();

        if (!is_null($result['location'])) {
            $result['location'] = $result['location']->jsonSerialize();
        }

        return $result;
    }
}
