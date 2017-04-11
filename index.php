<?php

require(__DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php');

$settings = [
    'brand' => 'Renault',
    'model' => 'Laguna',
    'yearFrom' => 2012,
    'body' => 'Combi',
];

$sites = [
    'av' => [
        'filter' => new \CarParser\Filters\AvFilter($settings),
        'parser' => new \CarParser\Parsers\AvParser(),
    ],
//    'ao' => [
//        'filter' => new \CarParser\Filters\AoFilter($settings),
//        'parser' => new \CarParser\Parsers\AoParser(),
//    ]
];

$db = new \CarParser\DB();
$request = new \CarParser\Request();
$mailer = new \CarParser\Mailer(parse_ini_file('settings.ini'));

try {
    foreach ($sites as $key => $site) {
        $items = $request->exec($site['filter'], $site['parser']);

        $dbData = $db->getData($key);

        foreach ($items as $item) {
            if (!in_array($item['id'], $dbData)) {
                $mailer->send('New Car at ' . strtoupper($key), $item['link']);
                $db->write($key, $item['id']);
            }
        }
    }
} catch (\Exception $e) {
    $mailer->send('Parse Car Error', $e->getMessage() . '<br><br>' . $e->getTraceAsString());
}