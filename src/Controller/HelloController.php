<?php

namespace App\Controller;

use App\Taxes\Calculator;
use Cocur\Slugify\Slugify;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{
    /**
     * @Route("/hello/{name?World}", name="hello")
     */
    public function hello($name, LoggerInterface $logger, Calculator $calculator, Slugify $slugify)
    {
        // $slugify = new Slugify();

        dump($slugify->slugify("Hello World"));

        $logger->info("Hello $name");
        $tva = $calculator->calcul(100);
        dump($tva);
        return new Response("Hello $name");
    }
}
