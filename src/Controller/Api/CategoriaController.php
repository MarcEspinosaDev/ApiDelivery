<?php

namespace App\Controller\Api;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/categoria")
 */
class CategoriaController extends AbstractFOSRestController
{
    private $categoriaRepository;

    public function __construct(CategoriaRepository $repo){
        $this->categoriaRepository = $repo;
    }
    //CRUD
    // Create, Update, Delete, Read

    //CREATE
    /**
     * @Rest\Post(path="/")
     * @Rest\View (serializerGroups={"post_categorias"}, serializerEnableMaxDepthChecks=true)
     */
    public function postCategorias(Request $request){
        // Formularios
        // 1- crear objeto vacio
        $category = new Categoria();
        //2- inicializamos el form
        $form = $this->createForm(CategoriaType::class, $category);
        // 3- El form maneja el request
        $form->handleRequest($request);
        // 4- Comprobar que no hay error
        if(!$form->isSubmitted() || !$form->isValid()){
            return $form;
        }
        //5- bien tot y a la bd
        $this->categoriaRepository->add($category, true);
        return $category;
    }
    // READ all
    /**
     * @Rest\Get(path="/")
     * @Rest\View(serializerGroups={"get_categorias"}, serializerEnableMaxDepthChecks=true)
     */
    public function getCategorias(){
        return $this->categoriaRepository->findAll();
    }

    //READ one by id
    /**
     * @Rest\Get(path="/{id}")
     * @Rest\View(serializerGroups={"get_categoria"}, serializerEnableMaxDepthChecks= true)
     */
    public function getCategoria(Request $request){
        $category = $this->categoriaRepository->find($request->get('id'));
        if (!$category){
            return new JsonResponse('Cannot find that category', Response::HTTP_NOT_FOUND);
        }
        return $category;
    }

    //UPDATE (Patch)
    /**
     * @Rest\Patch(path="/{id}")
     * @Rest\View(serializerGroups={"update_categorias"}, serializerEnableMaxDepthChecks= true)
     */

    public function updateCategoria(Request $request){
        $idCategory = $request->get('id');
        $category = $this->categoriaRepository->find($idCategory);
        if(!$category){
            return new JsonResponse('Not found', Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(CategoriaType::class,$category,['method'=>$request->getMethod()]);
        $form->handleRequest($request);
        //comprobar la validez del form
        if(!$form->isSubmitted() || !$form->isValid()){
            return new JsonResponse('Bad Data', 400);
        }
        $this->categoriaRepository->add($category, true);
        return $category;
    }

    //DELETE
    /**
     * @Rest\Delete(path="/{id}")
     */
    public function deleteCategorias(Request $request){
        $categoriaId = $request->get('id');
        $categoria = $this->categoriaRepository->find($categoriaId);
        if (!$categoria){
            return new JsonResponse('Not Found', 400);
        }
        $this->categoriaRepository->remove($categoria, true);
        return new JsonResponse('Deleted category',200);
    }
}

