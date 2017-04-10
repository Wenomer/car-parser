<?php

namespace Car\Filters;

use Car\Filter;

class AvFilter extends Filter
{
    protected $uri = 'https://cars.av.by/search';

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
        'body' => [
            'name' => 'body_id',
            'map' => [
                'Combi' => 2
            ]
        ],
        'yearFrom' => [
            'name' => 'year_from',
            'validateMap' => false
        ],
    ];
}