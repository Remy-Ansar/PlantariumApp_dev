<?php

namespace App\EventListener;

use App\Repository\UsersRepository;
use App\Repository\UserInfosRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RequestListener implements EventSubscriberInterface
{   
    public function __construct(

        private readonly UsersRepository $usersRepository,
        private readonly UserInfosRepository $userInfosRepository,
    )
    { }

    public function onKernelController(ResponseEvent $event): void
    {

        $response = $event->getResponse();
        $response->headers->set('user', 'userInfos');
        

    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
}