<?php

namespace App\Controller;

use App\Entity\Chien;
use App\Form\ChienType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/new", name="chien_add")
     * @Route("/edit/{id}", name="chien_edit")
     */
    public function new(Request $request, Chien $chien = null): Response
    {
        if (!$chien) {
            $chien = new Chien();
        }

        $form = $this->createForm(ChienType::class, $chien);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $chien = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chien);
            $entityManager->flush();

            return $this->redirectToRoute('chiens');
        }

        return $this->render('chien/new.html.twig', [
            'formAddChien' => $form->createView(),
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
