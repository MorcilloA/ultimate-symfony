<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AmountExtension extends AbstractExtension
{

    public function getFilters()
    {
        return [
            new TwigFilter("amount", [$this, 'amount'])
        ];
    }

    public function amount($value, string $currency = "€", string $separator = ",", string $thousandSep = " ")
    {
    
        $finalValue = $value / 100;

        $finalValue = number_format($finalValue, 2, $separator, $thousandSep);

        return $finalValue.$currency;

    }
}
