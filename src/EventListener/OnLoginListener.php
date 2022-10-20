<?php

namespace App\EventListener;

use App\Repository\ClienteRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class OnLoginListener
{
    private $repo;
    public function __construct(ClienteRepository $repository){
        $this->repo = $repository;
    }
    //listener de login success
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event){
        $data = $event->getData();
        $user = $event->getUser();
        if(!$user instanceof UserInterface){
            return;
        }
        $data['userId'] = $user->getId();
        $clienteId = null;
        $cliente = $this->repo->findOneBy(['user'=>$user]);
        if($cliente){
            $clienteId = $cliente->getId();
        }
        $data['idCliente'] = $clienteId;
        $event->setData($data);
    }
}