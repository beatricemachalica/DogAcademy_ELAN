<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Entity\Programmer;
use App\Form\AteliersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    /**
     * @Route("/sessions", name="sessions_index")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $sessions = $this->getDoctrine()
            ->getRepository(Session::class)
            ->findBy([], ['dateDebut' => 'ASC']);

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions
        ]);
    }

    /**
     * @Route("/news", name="session_add")
     * @Route("/edit/{id}", name="session_edit")
     */
    public function new(Request $request, Session $session = null): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$session) {
            $session = new Session();
        }

        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('sessions_index');
        }

        return $this->render('session/new.html.twig', [
            'formAddSession' => $form->createView(),
            // 'session' => $session,
            'editMode' => $session->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="session_delete")
     */
    public function delete(Session $session): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($session);
        $entityManager->flush();

        return $this->redirectToRoute('sessions_index');
    }

    // pour tester j'ai enlever le : @IsGranted("ROLE_ADMIN")
    /**
     * @Route("/addDuree/{id}", name="addAtelierToSession")
     */
    public function addAtelierToSession(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form2 = $this->createForm('App\Form\AteliersType', $session);

        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {

            // not needed :
            // $session = $form2->getData();
            // in paramconvert :
            // $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('sessions_index');
        }

        return $this->render('programmer/addDuree.html.twig', [
            'form' => $form2->createView(),
            'session' => $session,
            // 'editMode' => $session->getId() !== null
        ]);
    }

    /**
     * @Route("/{id}", name="session_show")
     */
    public function show(Session $session): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('session/show.html.twig', [
            'session' => $session
        ]);
    }
}
