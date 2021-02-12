<?php

namespace App\Taxes;

use Psr\Log\LoggerInterface;

class Calculator
{

    private $logger;

    public function __construct(LoggerInterface $loggerInterface, float $tva)
    {
        $this->logger = $loggerInterface;
    }

    public function calcul(float $prix): float
    {
        $this->logger->info("Un calcul a lieu : $prix");
        return $prix * (20 / 100);
    }
}
