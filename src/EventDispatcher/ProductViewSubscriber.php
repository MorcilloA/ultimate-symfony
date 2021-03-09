<?php

namespace App\EventDispatcher;

use App\Event\ProductViewEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductViewSubscriber implements EventSubscriberInterface
{

    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            'product.view' => 'sendMailOnProductView'
        ];
    }

    public function sendMailOnProductView(ProductViewEvent $productViewEvent){
        $this->logger->info("La page du produit ".$productViewEvent->getProduct()->getName()." a été visionné");
    }

}