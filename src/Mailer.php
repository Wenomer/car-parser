<?php

namespace CarParser;

class Mailer
{
    protected $config;

    /**
     * Mailer constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function send($subject, $body)
    {
        $mail = new \PHPMailer();

        $mail->isSMTP();
        $mail->Host = $this->config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $this->config['user'];
        $mail->Password = $this->config['pass'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($this->config['user']);
        $mail->addAddress($this->config['user']);
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $body;

        if(!$mail->send()) {
            error_log('Message could not be sent' . $mail->ErrorInfo);
            return false;
        }

        return true;
    }
}