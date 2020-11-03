<?php


namespace App\Mail;

interface SendingProviderInterface
{
    public function sendStockChanged(string $productName, int $previousStock, int $newStock);
}
