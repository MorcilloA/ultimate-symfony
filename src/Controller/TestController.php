<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{

    public function index()
    {
        dd("ça marche");
    }

    /**
     * @Route("/test/{age<\d+>?0}", name="test", methods={"GET', "POST"}, host="localhost", schemes={"http", "https"})
     */
    public function test(Request $request, $age)
    {
        // Pas nécessaire grâce au $age dans les arguments de la fonction
        // $age = $request->attributes->get("age", 0);

        return new Response("Vous avez $age ans");
    }
}
