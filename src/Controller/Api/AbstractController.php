<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;

class AbstractController extends AbstractFOSRestController
{
    //metodo intermedio para sobrescribir las opciones del form y desactivar el --csrf_token--
}