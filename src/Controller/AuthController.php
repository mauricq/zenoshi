<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthController
 * @package App\Controller
 */
class AuthController extends AbstractFOSRestController
{
    /**
     * @Route("/auth/token", name="get_token", methods={"GET","POST"})
     */
    public function getTokenAction()
    {
    }
}
