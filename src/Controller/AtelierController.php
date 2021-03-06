<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Form\AtelierType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $ateliers = $this->getDoctrine()
            ->getRepository(Atelier::class)
            ->findAll();

        return $this->render('atelier/index.html.twig', [
            'ateliers' => $ateliers,
        ]);
    }

    /**
     * @Route("/new", name="atelier_add")
     * @Route("/edit/{id}", name="atelier_edit")
     */
    public function new(Request $request, Atelier $atelier = null): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$atelier) {
            $atelier = new Atelier();
        }
        $form = $this->createForm(AtelierType::class, $atelier);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $atelier = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($atelier);
            $entityManager->flush();

            return $this->redirectToRoute('ateliers_index');
        }

        return $this->render('atelier/new.html.twig', [
            'formAddAtelier' => $form->createView(),
            'editMode' => $atelier->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="atelier_delete")
     */
    public function delete(Atelier $atelier): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($atelier);
        $entityManager->flush();

        return $this->redirectToRoute('ateliers_index');
    }
}
