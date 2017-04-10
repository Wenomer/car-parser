<?php

namespace Car\Parsers;

use Car\Parser;
use Sunra\PhpSimple\HtmlDomParser;

class AvParser extends Parser
{
    public function parse($data)
    {
        $items = [];
        $dom = HtmlDomParser::str_get_html($data);

        foreach ($dom->find('.listing .listing-item') as $elem) {
            $items[] = [
                'id' => $elem->find('.listing-item-body .bookmark')[0]->{'data-id-ids'},
                'href' => $elem->find('.listing-item-image a')[0]->href,
            ];
        }

        return $items;
    }
}