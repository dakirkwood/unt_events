<?php

namespace Drupal\unt_events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UntApiListener implements EventSubscriberInterface
{

  public function onKernelRequest(GetResponseEvent $event)
  {
    //var_dump($event);die;
    $request = $event->getRequest();
  }

  public static function getSubscribedEvents()
  {
    return [
      KernelEvents::REQUEST => 'onKernelRequest',
    ];
  }
}
