<?php

namespace CarParser\Filters;

use CarParser\Filter;

class AoFilter extends Filter
{
    protected $method = "POST";

    protected $uri = 'http://ab.onliner.by/#';

    protected $optionsMap = [
        'brand' => [
            'name' => '',
            'validateMap' => false,
        ],
        'model' => [
            'name' => '',
            'validateMap' => false,
        ],
        'body' => [
            'name' => '',
            'validateMap' => false
        ],
        'yearFrom' => [
            'name' => '',
            'validateMap' => false
        ],
    ];

    public function getRequestUrl()
    {
        return 'http://ab.onliner.by/#body_type[]=2&min-year=2012&currency=USD&sort[]=creation_date&page=1&car[0][52][m]=692';
    }


}