<?php

namespace App\Controller;

use App\Entity\Maitre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/maitres")
 */
class MaitreController extends AbstractController
{
    /**
     * @Route("/", name="maitres_index")
     */
    public function index(): Response
    {
        $maitres = $this->getDoctrine()
            ->getRepository(Maitre::class)
            ->findAll();

        return $this->render('maitre/index.html.twig', [
            'maitres' => $maitres,
        ]);
    }

    /**
     * @Route("/{id}", name="maitre_show", methods="GET")
     */
    public function show(Maitre $maitre): Response
    {
        return $this->render('maitre/show.html.twig', ['maitre' => $maitre]);
    }
}
