<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class MessageService
{
    private $logFilePath;

    public function __construct(string $logFilePath)
    {
        $this->logFilePath = $logFilePath;
    }

    public function send($customers, $service, $title, $message)
    {
        self::{"sendVia" . $service}($customers, $title, $message);
//        return self::sendViaEmail($customers, $title, $message);
    }

    private function sendViaEmail($customers, $title, $message) {
        $emails = self::takeColumn($customers, 'getEmail');

        return $this->writeToFile($emails, $title, $message, 'Email');
    }
    public function sendViaSms($customers, $title, $message) {
        $numbers = self::takeColumn($customers, 'getPhoneNumber');

        return $this->writeToFile($numbers, $title, $message, 'Sms');
    }
    public function sendViaWebpush($customers, $title, $message) {
        $numbers = self::takeColumn($customers, 'getPhoneNumber');

        return $this->writeToFile($numbers, $title, $message, 'webpush');

    }
    public function sendViaTelegram($customers, $title, $message) {
        $numbers = self::takeColumn($customers, 'getPhoneNumber');

        return $this->writeToFile($numbers, $title, $message, 'telegram');
    }
    public function sendViaViber($customers, $title, $message) {
        $numbers = self::takeColumn($customers, 'getPhoneNumber');

        return $this->writeToFile($numbers, $title, $message, 'viber');
    }

    private static function takeColumn($customers, $method) {
        return array_map(function($customer) use ($method) {
            return $customer->{$method}();
        }, $customers);
    }

    private function writeToFile($customerData, $title, $message, $type) {
        $data = "Via: $type\n";
        $data .= "Title: $title\n";
        $data .= "Data:\n";
        if ($customerData) {
            foreach ($customerData as $col) {
                $data .= "$col\n";
            }
        }

        $data .= "\nMessage:\n$message\n";
        $data = $data . "\n\n\n";

        $filesystem = new Filesystem();

        $filesystem->appendToFile($this->logFilePath, $data);

        return true;
    }
}
