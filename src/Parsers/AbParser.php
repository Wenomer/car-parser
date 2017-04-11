<?php

namespace CarParser\Parsers;

use Sunra\PhpSimple\HtmlDomParser;

class AbParser implements ParserInterface
{
    public function parse($data)
    {
        $items = [];
        $dom = HtmlDomParser::str_get_html($data);

        foreach ($dom->find('#advertsListContainer .a_m_o') as $elem) {
            $items[] = [
                'id' => str_replace('clipboard', '', $elem->find('.a_node .clipboard')[0]->id),
                'link' => 'https://www.abw.by' . $elem->find('a')[0]->href,
            ];
        }

        return $items;
    }
}