<?php

namespace Car\Filters;

use Car\Filter;

class AoFilter extends Filter
{
    protected $optionsMap = [
        'brand' => [
            'name' => 'brand_id[0]',
            'map' => [
                'Renault' => 1039
            ]
        ],
        'model' => [
            'name' => 'model_id[0]',
            'map' => [
                'Laguna' => 1983
            ]
        ],
        'yearFrom' => [
            'name' => 'year_from',
            'noValidateMap' => true
        ]
    ];
}