<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaitreController extends AbstractController
{
    /**
     * @Route("/maitre", name="maitre")
     */
    public function index(): Response
    {
        return $this->render('maitre/index.html.twig', [
            'controller_name' => 'MaitreController',
        ]);
    }
}
