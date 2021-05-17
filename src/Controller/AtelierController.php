<?php

namespace App\Controller;

use App\Entity\Atelier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ateliers")
 */
class AtelierController extends AbstractController
{
    /**
     * @Route("/", name="ateliers_index")
     */
    public function index(): Response
    {
        $ateliers = $this->getDoctrine()
            ->getRepository(Atelier::class)
            ->findAll();

        return $this->render('atelier/index.html.twig', [
            'ateliers' => $ateliers,
        ]);
    }
}
