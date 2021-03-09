<?php

namespace App\EventDispatcher;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use App\Event\PurchaseSuccessEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mime\Address;

class PurchaseSuccessEmailSubscriber implements EventSubscriberInterface
{

    protected $logger;
    protected $security;
    protected $mailer;

    public function __construct(LoggerInterface $logger, MailerInterface $mailer, Security $security)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            'purchase.success' => 'sendSuccessEmail'
        ];
    }

    public function sendSuccessEmail(PurchaseSuccessEvent $purchaseSuccessEvent)
    {

        // 1. Récupérer l'user actuellement en ligne ##> Security
        /** @var User */
        $currentUser = $this->security->getUser();

        // 2. Récupérer la commande ##> dans le purchaseEvent
        $purchase = $purchaseSuccessEvent->getPurchase();

        // 3. Ecrire le mail ##> nouveau TemplatedEmail
        $email = new TemplatedEmail();

        $email->to(new Address($currentUser->getEmail(), $currentUser->getFullName()))
            ->from("contact@mail.com")
            ->subject("Bravo votre commande ({$purchase->getId()}) a bien été confirmée")
            ->htmlTemplate("emails/purchase_success.html.twig")
            ->context([
                "user" => $currentUser,
                "purchase" => $purchase
            ]);

        // 4. Envoyer le mail ##> MailerInterface
        $this->mailer->send($email);


        // $email->from

        $this->logger->info("Email envoyé pour la commande n°" . $purchaseSuccessEvent->getPurchase()->getId());
    }
}
