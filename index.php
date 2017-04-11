<?php

require(__DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php');

$db = new \CarParser\DB();
$request = new \CarParser\Request();
$mailer = new \CarParser\Mailer(parse_ini_file('settings.ini'));

$siteSettings = [
    'av' => [
        'url' => 'https://cars.av.by/search?brand_id%5B0%5D=1039&model_id%5B0%5D=1983&body_id=2&engine_volume_min=&engine_volume_max=&year_from=2012&year_to=&mileage_min=&mileage_max=&driving_id=&currency=USD&price_from=&price_to=&exchange=&interior_material=&interior_color=&region_id=&submit=%D0%9D%D0%B0%D0%B9%D1%82%D0%B8%20%D0%BE%D0%B1%D1%8A%D1%8F%D0%B2%D0%BB%D0%B5%D0%BD%D0%B8%D1%8F&sort=date&order=desc',
        'method' => 'GET',
    ],
    'ab' => [
        'url' => 'https://www.abw.by/index.php?set_small_form_1=1&act=public_search&do=search&index=1&adv_type=1&adv_group=&marka%5B%5D=45&model%5B%5D=622&type_engine=&transmission=&vol1=&vol2=&probeg_col1=&probeg_col2=&year1=2012&year2=2017&cost_val1=&cost_val2=&u_country=1&u_city=&period=&sort=&na_rf=&type_body=3&privod=&key_word_a=&volume1=&volume2=&cylinders=&doors=&probeg_type=&class=&photo=&adv_type=1&period=&sort=date_add',
        'method' => 'GET',
    ],
    'ao' => [
        'url' => 'http://ab.onliner.by/search',
        'method' => 'POST',
        'params' => [
            'form_params' => [
                'body_type[]' => 2,
                'min-year' => 2012,
                'car[0][52][m]' => 692,
            ]
        ],
    ],
];

$parsers = [
    'av' => new \CarParser\Parsers\AvParser(),
    'ao' => new \CarParser\Parsers\AoParser(),
    'ab' => new \CarParser\Parsers\AbParser(),
];

try {
    foreach ($siteSettings as $key => $settings) {
        $knownCars = $db->getData($key);

        /** @var \CarParser\Parsers\ParserInterface $parser */
        $parser = $parsers[$key];

        $carsRawData = $request->exec($settings);
        $cars = $parser->parse($carsRawData);

        foreach ($cars as $car) {
            if (!in_array($car['id'], $knownCars)) {
                $mailer->send('New Car at ' . strtoupper($key), $car['link']);
                $db->write($key, $car['id']);
            }
        }
    }
} catch (\Exception $e) {
    $mailer->send('Parse Car Error', $e->getMessage() . '<br><br>' . $e->getTraceAsString());
}