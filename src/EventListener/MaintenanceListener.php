<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class MaintenanceListener
{
    public const IS_MAINTENANCE = false;
    public function __construct(private readonly Environment $twig)
    {

    }

    #[AsEventListener(event: KernelEvents::REQUEST, priority: 2000)]
    public function onKernelRequest(RequestEvent $event): void
    {
        if (self::IS_MAINTENANCE){
            $response = new Response($this->twig->render('maintenance.html.twig'));
            $event->setResponse($response);
        }
    }
}
