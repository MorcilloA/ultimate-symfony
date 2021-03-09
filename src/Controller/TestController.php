<?php

namespace App\Controller;

use App\Taxes\Calculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{

    protected $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        // dump($this->calculator->calcul(50));
        // dd("ça marche");
    }

    /**
     * @Route("/test/{age<\d+>?0}", name="test")
     */
    public function test(Request $request, $age)
    {
        // Pas nécessaire grâce au $age dans les arguments de la fonction
        // $age = $request->attributes->get("age", 0);

        return new Response("Vous avez $age ans");
    }
}
