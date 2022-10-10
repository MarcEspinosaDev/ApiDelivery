<?php

namespace App\Controller\Api;

use App\Entity\Cliente;
use App\Form\ClienteType;
use App\Repository\ClienteRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/cliente")
 */
class ClienteController extends AbstractFOSRestController
{
    private $clienteRepository;

    public function __construct(ClienteRepository $repo){
        $this->clienteRepository = $repo;
    }
    //CRUD
    //CREATE
    /**
     * @Rest\Post(path="/")
     * @Rest\View(serializerGroups={"post_cliente"}, serializerEnableMaxDepthChecks=true)
     */
    public function createCliente(Request $request){
        $cliente = new Cliente();
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);
        if(!$form->isSubmitted() || !$form->isValid()){
            return $form;
        }
        $this->clienteRepository->add($cliente, true);
        return $cliente;
    }
    //READ all
    /**
     * @Rest\Get(path="/")
     * @Rest\View(serializerGroups={"get_clientes"}, serializerEnableMaxDepthChecks=true)
     */
    public function readCliente(){
        return $this->clienteRepository->findAll();
    }
    //READ one
    /**
     * @Rest\Get(path="/{id}")
     * @Rest\View(serializerGroups={"get_cliente"}, serializerEnableMaxDepthChecks=true)
     */
    public function getCliente(Request $request){
        $cliente = $this->clienteRepository->find($request->get('id'));
        if(!$cliente){
            return new JsonResponse('Cannot find client', Response::HTTP_BAD_REQUEST);
        }
        return $cliente;
    }
    //UPDATE
    /**
     * @Rest\Patch(path="/{id}")
     * @Rest\View(serializerGroups={"patch_cliente"}, serializerEnableMaxDepthChecks=true)
     */
    public function updateCliente(Request $request){
        $clienteId = $request->get('id');
        $cliente = $this->clienteRepository->find($clienteId);
        if (!$cliente){
            return new JsonResponse('Cannot fint that client',Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(ClienteType::class, $cliente, ['method'=>$request->getMethod()]);
        $form->handleRequest($request);
        if(!$form->isSubmitted() || !$form->isValid()){
            return new JsonResponse('Bad Data', 400);
        }
        $this->clienteRepository->add($cliente, true);
        return $cliente;
    }
    //Delete
    /**
     * @Rest\Delete(path="/{id}")
     */
    public function deleteClientes(Request $request){
        $clienteId = $request->get('id');
        $cliente = $this->clienteRepository->find($clienteId);
        if(!$cliente){
            return new JsonResponse('Bad Data', 400);
        }
        $this->clienteRepository->remove($cliente, true);
        return new JsonResponse('Deleted category', 200);
    }

}