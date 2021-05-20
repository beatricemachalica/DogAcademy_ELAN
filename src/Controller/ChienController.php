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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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

            return $this->redirectToRoute('chiens_index');
        }

        return $this->render('chien/new.html.twig', [
            'formAddChien' => $form->createView(),
            'editMode' => $chien->getId() !== null
        ]);
    }

    /**
     * @Route("/{id}", name="chien_show", methods="GET")
     */
    public function show(Chien $chien): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('chien/show.html.twig', ['chien' => $chien]);
    }

    /**
     * @Route("/delete/{id}", name="chien_delete")
     */
    public function delete(Chien $chien): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($chien);
        $entityManager->flush();

        return $this->redirectToRoute('chiens_index');
    }
}
