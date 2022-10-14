<?php

namespace App\Controller\Api;

use App\Repository\MunicipiosRepository;
use App\Repository\ProvinciasRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route(path="/provincia")
 */
class ProvinciasController extends AbstractFOSRestController
{
    private $provinciaRepository;
    private $municipioRepository;

    public function __construct(ProvinciasRepository $repoP, MunicipiosRepository $repoM){
        $this->provinciaRepository= $repoP;
        $this->municipioRepository= $repoM;
    }
    // Get provincias y get by id municipios
    //GET provincias
    /**
     * @Rest\Get (path="/")
     * @Rest\View (serializerGroups={"get_provincia"}, serializerEnableMaxDepthChecks=true)
     */
    public function getProvincia(){
        return $this->provinciaRepository->findAll();
    }

    //Get municipios
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"get_municipio"}, serializerEnableMaxDepthChecks=true)
     */
    public function getMunicipios(Request $request){
        return $this->municipioRepository->findBy(['idProvincia'=>$request->get('id')]);
    }
}