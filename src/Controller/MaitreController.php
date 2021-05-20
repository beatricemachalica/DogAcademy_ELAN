<?php

namespace App\Controller;

use App\Entity\Maitre;
use App\Form\MaitreType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $maitres = $this->getDoctrine()
            ->getRepository(Maitre::class)
            ->findAll();

        return $this->render('maitre/index.html.twig', [
            'maitres' => $maitres,
        ]);
    }

    /**
     * @Route("/new", name="maitre_add")
     * @Route("/edit/{id}", name="maitre_edit")
     */
    public function new(Request $request, Maitre $maitre = null): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$maitre) {
            $maitre = new Maitre();
        }

        $form = $this->createForm(MaitreType::class, $maitre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $maitre = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($maitre);
            $entityManager->flush();

            return $this->redirectToRoute('maitres_index');
        }

        return $this->render('maitre/new.html.twig', [
            'formAddMaitre' => $form->createView(),
            'editMode' => $maitre->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="maitre_delete")
     */
    public function delete(Maitre $maitre): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($maitre);
        $entityManager->flush();

        return $this->redirectToRoute('maitres_index');
    }

    /**
     * @Route("/{id}", name="maitre_show", methods="GET")
     */
    public function show(Maitre $maitre): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('maitre/show.html.twig', ['maitre' => $maitre]);
    }
}
