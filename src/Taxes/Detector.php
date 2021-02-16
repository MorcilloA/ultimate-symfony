<?php

namespace App\Taxes;

use Psr\Log\LoggerInterface;

class Detector
{

    protected $seuil;

    public function __construct(int $seuil)
    {
        $this->seuil = $seuil;
    }

    public function detect(int $amount): bool
    {
        if ($amount > $this->seuil) {
            return true;
        }

        return false;
    }
}
