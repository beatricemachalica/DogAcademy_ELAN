<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Form\AteliersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/sessions")
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/", name="sessions_index")
     */
    public function index(): Response
    {
        // la fonction index va afficher la liste des sessions
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // denyAccessUnlessGranted : permet de refuser un accès à l'intérieur d'un controleur
        // ici si l'utilisateur n'est pas connecté = IS_AUTHENTICATED_FULLY

        $sessions = $this->getDoctrine()
            ->getRepository(Session::class)
            ->findBy([], ['dateDebut' => 'ASC']);
        // on appelle la doctrine (qui s'occupe de la BDD et l'ORM), puis le repositoy de Session
        // les sessions seront affichées dans l'ordre : des plus récentes au plus anciennes

        // retourne une vue avec les données des sessions pour pouvoir les afficher
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
        // la fonction new ajoute ou modifie une session de formation
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // denyAccessUnlessGranted : permet de refuser un accès à l'intérieur d'un controleur
        if (!$session) {
            $session = new Session();
        }
        // création du formulaire à partir de la classe SessionType
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);
        // handleRequest() = read data off of the correct PHP superglobals (i.e. $_POST or $_GET) 
        // based on the HTTP method configured on the form (POST is default).

        if ($form->isSubmitted() && $form->isValid()) {
            // si le formulaire est valide et soumis on récupère les données
            $session = $form->getData();
            // on communique avec la doctrine puis le manager :
            // "The $this->getDoctrine()->getManager() method gets Doctrine’s entity manager object, 
            // which is the most important object in Doctrine. 
            // It’s responsible for saving objects to, and fetching objects from, the database."
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            // tells Doctrine to “manage” the $session object
            $entityManager->flush();
            // if data needs to be persisted to the database =
            // an INSERT query create a new row in the table
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
        // la fonction delete va supprimer une session
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($session);
        // the remove() method notifies Doctrine that you’d like to remove the given object from the database.
        $entityManager->flush();
        // The DELETE query isn’t actually executed until the flush() method is called.

        return $this->redirectToRoute('sessions_index');
    }

    /**
     * @Route("/addDuree/{id}", name="addAtelierToSession")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addAtelierToSession(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        // cette fonction va ajouter un programme (un atelier et sa duree à une session)
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form2 = $this->createForm('App\Form\AteliersType', $session);
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            $entityManager->persist($session);
            $entityManager->flush();
            return $this->redirectToRoute('sessions_index');
        }
        return $this->render('programmer/addDuree.html.twig', [
            'form' => $form2->createView(),
            'session' => $session,
        ]);
    }

    // il est préférable de laisser la fonction "show" à la fin du controleur
    // en effet, le système de routing risque de rencontrer des conflits
    // car l'{id} requis peut être "confondu"

    /**
     * @Route("/{id}", name="session_show")
     */
    public function show(Session $session): Response
    {
        // cette fonction a pour but de montrer les détails d'une session
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // redirection vers une page consacrée uniquement à une session précise
        return $this->render('session/show.html.twig', [
            'session' => $session
        ]);
    }
}
