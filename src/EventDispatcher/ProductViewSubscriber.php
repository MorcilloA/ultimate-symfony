<?php

namespace App\EventDispatcher;

use Psr\Log\LoggerInterface;
use App\Event\ProductViewEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductViewSubscriber implements EventSubscriberInterface
{

    protected $logger;
    protected $mailer;

    public function __construct(LoggerInterface $logger, MailerInterface $mailer)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            'product.view' => 'sendMailOnProductView'
        ];
    }

    public function sendMailOnProductView(ProductViewEvent $productViewEvent)
    {

        // $email = new TemplatedEmail();
        // // $email = new Email();

        // $email->from(new Address("contact@mail.com", "Infos de la boutique"))
        //     ->to("admin@mail.com")
        //     ->text("Un visiteur est en train de voir la page du produit n°" . $productViewEvent->getProduct()->getId())
        //     // ->html("<h1>Visite du produit {$productViewEvent->getProduct()->getName()}</h1>")
        //     ->htmlTemplate("emails/product_view.html.twig")
        //     ->context([
        //         "product" => $productViewEvent->getProduct()
        //     ])
        //     ->subject("Visite du produit n°" . $productViewEvent->getProduct()->getId());

        // $this->mailer->send($email);

        $this->logger->info("La page du produit " . $productViewEvent->getProduct()->getName() . " a été visionné");
    }
}
