<?php

namespace App\Controller\Api;

use App\Entity\Direccion;
use App\Form\DireccionType;
use App\Repository\ClienteRepository;
use App\Repository\DireccionRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route(path="/direccion")
 */
class DireccionController extends AbstractFOSRestController
{
    private $direccionRepository;

    public function __construct(DireccionRepository $repo){
        $this->direccionRepository = $repo;
    }

    //CRUD
    //CREATE
    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"post_direccion"}, serializerEnableMaxDepthChecks=true)
     */
    public function crearDireccion(Request $request){
        $direccion = new Direccion();
        $form = $this->createForm(DireccionType::class, $direccion);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()){
            return $form;
        }
        $this->direccionRepository->add($direccion, true);
        return $direccion;
    }
    //Get devuelve tosdas las direcciones de un cliente
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"get_direccion"}, serializerEnableMaxDepthChecks=true)
     */
    public function getDireccion(Request $request, ClienteRepository $clienteRepository){
        $idCliente = $request->get('id');
        $cliente = $clienteRepository->find($idCliente);
        if (!$cliente){
            return new JsonResponse('', Response::HTTP_NOT_FOUND);
        }
        $direcciones = $this->direccionRepository->findBy(['cliente'=>$idCliente]);
        return $direcciones;
    }
    //Update
    /**
     * @Rest\Patch (path="/{id}")
     * @Rest\View (serializerGroups={"patch_direccion"}, serializerEnableMaxDepthChecks=true)
     */
    public function updateDireccion(Request $request)
    {
        $idDireccion = $request->get('id');
        $direccion = $this->direccionRepository->find($idDireccion);
        if (!$direccion) {
            return new JsonResponse('Not exist', Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(DireccionType::class, $direccion, ['method'=>$request->getMethod()]);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()){
            return $form;
        }
        $this->direccionRepository->add($direccion, true);
        return $direccion;
    }

    //Delete
    /**
     * @Rest\Delete (path="/{id}")
     */
    public function deleteDireccion(Request $request){
        $idDireccion = $request->get('id');
        $direccion = $this->direccionRepository->find($idDireccion);
        if (!$direccion){
            return new JsonResponse('Bad Data', 400);
        }
        $this->direccionRepository->remove($direccion, true);
        return new JsonResponse('Deleted direccion', 200);
    }
}