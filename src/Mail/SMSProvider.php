<?php
namespace App\Mail;

class SMSProvider implements SendingProviderInterface
{

    public function sendStockChanged(string $productName, int $previousStock, int $newStock)
    {

    }
}
