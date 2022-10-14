<?php

namespace App\Controller\Api;

use App\Repository\RestauranteRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/restaurante")
 */
class RestauranteController extends AbstractFOSRestController
{
    private $restaurnteRepository;

    public function __construct(RestauranteRepository $repo){
        $this->restaurnteRepository = $repo;
    }

    //1- devolver restaurante por id
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"get_restaurante"}, serializerEnableMaxDepthChecks=true)
     */
    public function getRestaurante(Request $request){
        return $this->restaurnteRepository->find($request->get('id'));
    }
    //2- Devolver listado de restaurantes, segun dia,hora y municipio
    // 1. seleccionamls la direccion a la que se envia
    // 2. dia y hora del reparto
    // 3. mostrar restaurantes de esas condiciones
    /**
     * @Rest\Post (path="/filtered")
     * @Rest\View (serializerGroups={"filter_restaurante"}, serializerEnableMaxDepthChecks=true)
     */
    public function filterRestaurante(Request $request){
        $dia = $request->get('dia');
        $hora = $request->get('hora');
        $idMunicipio = $request->get('municipio');
        //comprobar que tienen los datos, si no viene alguno -> bad request
        $restaurantes = $this->restaurnteRepository->findByDayTimeMunicipio($dia, $hora, $idMunicipio);
        return $restaurantes;
    }
}