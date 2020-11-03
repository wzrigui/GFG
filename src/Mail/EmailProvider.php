<?php
namespace App\Mail;

class EmailProvider implements SendingProviderInterface
{
    const FROM_EMAIL = 'php.coding.challenge@global-fashion-group.com';

    const TO_EMAIL = 'seller.email@global-fashion-group.com';

    const FILE_TO_LOG = '/tmp/email_log.txt';

    public function sendStockChanged(string $productName, int $previousStock, int $newStock)
    {
        $subject = 'Stock updated';

        $message = sprintf(
            'The stock of your product "%s" has been modified from %d to %d',
            $productName,
            $previousStock,
            $newStock
        );

        $this->send(self::FROM_EMAIL, self::TO_EMAIL, $subject, $message);
    }

    private function send(string $from, string $to, string $subject, string $message)
    {
        $log = sprintf(
            "Email sent from %s to %s. Subject: %s; Message: %s\n",
            $from,
            $to,
            $subject,
            $message
        );

        // Using the log as an implementation for the email provider
        file_put_contents(self::FILE_TO_LOG, $log, FILE_APPEND);
    }
}
