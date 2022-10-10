<?php

namespace App\Controller\Api;

use App\Entity\Direccion;
use App\Repository\DireccionRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use http\Env\Request;

/**
 * @Rest\Route(path=">/direccion")
 */
class DireccionController extends AbstractFOSRestController
{
    private $repo;

    public function __construct(DireccionRepository $repo){
        $this->repo = $repo;
    }

    //CRUD
    //CREATE
    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"get_direccion"}, serializerEnableMaxDepthChecks=true)
     */
    public function crearDireccion(Request $request){
        $direccion = new Direccion();
    }
}