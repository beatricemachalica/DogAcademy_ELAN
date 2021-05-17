<?php

namespace App\Controller;

use App\Entity\Chien;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chiens")
 */
class ChienController extends AbstractController
{
    /**
     * @Route("/", name="chiens_index")
     */
    public function index(): Response
    {
        $chiens = $this->getDoctrine()
            ->getRepository(Chien::class)
            ->findAll();

        return $this->render('chien/index.html.twig', [
            'chiens' => $chiens,
        ]);
    }

    /**
     * @Route("/{id}", name="chien_show", methods="GET")
     */
    public function show(Chien $chien): Response
    {
        return $this->render('chien/show.html.twig', ['chien' => $chien]);
    }
}
