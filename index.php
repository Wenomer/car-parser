<?php

require_once('loader.php');

$client = new \GuzzleHttp\Client();

$settings = [
    'brand' => 'Renault',
    'model' => 'Laguna',
    'yearFrom' => 2012,
    'body' => 'Combi',
];

$filter = new \Car\Filters\AvFilter($settings);

$sites = [
    'av' => [
        'filter' => new \Car\Filters\AvFilter($settings),
        'parser' => new \Car\Parsers\AvParser(),
    ]
];

foreach ($sites as $key => $site) {
    $res = $client->request('GET', $site['filter']->getRequestUrl());

    if ($res->getStatusCode() !== 200) {
        throw new \Exception(sprintf('Response code %d, site: %s', $res->getStatusCode(), $key));
    }

    $items = $site['parser']->parse($res->getBody()->read(100000000));

    foreach ($items as $item) {
        sendMail($item);
    }
}

function sendMail($item)
{
    $mail = new PHPMailer;

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'user@example.com';                 // SMTP username
    $mail->Password = 'secret';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'New Car';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
}
