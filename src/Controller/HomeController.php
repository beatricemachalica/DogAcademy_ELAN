<?php

namespace App\Controller;

use App\Entity\Formation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("", name="home")
     */
    public function index(): Response
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('accueil');
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/accueil", name="accueil")
     */
    public function accueil(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // on va vérifier l'authentification du User
        return $this->render('home/accueil.html.twig', [
            'user' => $this->getUser()->getUsername(),
        ]);
    }
    /**
     * @Route("/conditions", name="conditions")
     */
    public function conditions(): Response
    {
        return $this->render('home/conditions.html.twig', [
            'data' => 'data',
        ]);
    }
    /**
     * @Route("/liste", name="liste_formations")
     */
    public function liste(): Response
    {
        $formations = $this->getDoctrine()
            ->getRepository(Formation::class)
            ->findAll();

        return $this->render('home/liste.html.twig', [
            'formations' => $formations,
        ]);
    }
}
