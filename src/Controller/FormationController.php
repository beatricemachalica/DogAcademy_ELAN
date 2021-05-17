<?php

namespace App\Controller;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formations")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/", name="formations_index")
     */
    public function index(): Response
    {
        $formations = $this->getDoctrine()
            ->getRepository(Formation::class)
            ->findAll();

        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }
}
