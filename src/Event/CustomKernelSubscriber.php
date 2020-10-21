<?php

namespace App\Event;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class CustomKernelSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => 'onKernelRequest'
        ];
    }

    public function onKernelRequest()
    {
        //die('Je viens de mettre le foutoir dans symfony');
    }
}