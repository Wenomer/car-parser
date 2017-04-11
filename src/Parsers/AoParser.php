<?php

namespace CarParser\Parsers;

class AoParser implements ParserInterface
{
    public function parse($data)
    {
        $items = [];
        $data = json_decode($data);

        foreach ($data->result->advertisements as $key => $elem) {
            $items[] = [
                'id' => $elem->id,
                'link' => 'http://ab.onliner.by/car/' . $elem->id
            ];
        }

        return $items;
    }
}