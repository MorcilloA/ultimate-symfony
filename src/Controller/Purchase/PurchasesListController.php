<?php

namespace App\Controller\Purchase;

use App\Entity\User;
use Twig\Environment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PurchasesListController extends AbstractController
{

    // protected $security;
    // protected $router;
    // protected $twig;

    // public function __construct(Security $security, RouterInterface $router, Environment $twig)
    // {

    //     $this->security = $security;
    //     $this->router = $router;
    //     $this->twig = $twig;
    // }

    /**
     * @Route("/purchases", name="purchase_index")
     * @IsGranted("ROLE_USER", message="Vous devez être connecté pour accéder à vos commandes")
     */
    public function index()
    {
        // 1. S'assurer que la personne est connectée -> Security
        /** @var User */
        $user = $this->getUser();
        // $user = $this->security->getUser();
        // if (!$user) {
        //     // Générer une URL en fonction du nom d'une route
        //     // $url = $this->router->generate("homepage");
        //     // Redirection
        //     // return new RedirectResponse($url);
        //     throw new AccessDeniedException("Vous devez être connecté pour accéder à vos commandes");
        // }

        // 2. Savoir QUI est connecté -> Security


        // 3. Passer l'utilisateur connecté à twig -> Environment de Twig / Response
        // $html = $this->twig->render('purchase/index.html.twig', [
        //     'purchases' => $user->getPurchases()
        // ]);
        // return new Response($html);

        return $this->render('purchase/index.html.twig', [
            'purchases' => $user->getPurchases()
        ]);
    }
}
