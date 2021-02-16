<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{

    // ------- L'AbstractController s'occupe de ça
    // protected $twig;

    // public function __construct(Environment $twig)
    // {
    //     $this->twig = $twig;
    // }

    /**
     * @Route("/hello/{name?World}", name="hello")
     */
    public function hello($name)
    {
        return $this->render('hello.html.twig', [
            "name" => $name
        ]);
    }

    /**
     * @Route("/example", name="example")
     */
    public function example()
    {
        return $this->render('example.html.twig', [
            "age" => 21
        ]);
    }

    // ----- la fonction render existe dans l'AbstractController ----//

    // protected function render(string $path, array $variables = [])
    // {
    //     $html = $this->twig->render($path, $variables);

    //     return new Response($html);
    // }
}
