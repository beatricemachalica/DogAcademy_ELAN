<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/recherche", name="recherche")
     */
    public function index(SessionRepository $repository): Response
    {
        $sessions = $repository->findSearch();
        return $this->render('search/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }
}
