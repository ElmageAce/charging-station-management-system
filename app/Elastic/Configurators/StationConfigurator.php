<?php

namespace App\Elastic\Configurators;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class StationConfigurator extends IndexConfigurator
{
    use Migratable;

    /**
     * @var array
     */
    protected $settings = [
        'number_of_shards' => 5,
        'number_of_replicas' => 0,
    ];

    protected $defaultMapping = [
        'properties' => [
            'id' => [
                'type' => 'long',
            ],
            'created_at' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss',
            ],
            'updated_at' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss',
            ],
            'location' => [
                'type' => 'geo_shape'
            ],
            'name' => [
                'type' => 'text'
            ],
            'company' => [
                'properties' => [
                    'id' => [
                        'type' => 'long'
                    ],
                    'name' => [
                        'type' => 'text'
                    ]
                ]
            ]
        ]
    ];
}
