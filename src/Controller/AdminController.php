<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * Require ROLE_ADMIN for only this controller method.
     * 
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminPanel(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        return $this->render('admin/index.html.twig', [
            'actual' => $this->getUser()->getUsername(),
            'users' => $users,
        ]);
    }
    // IsGranted est une autre façon de controller l'accès des users
    // (ne pas oublier d'import la classe si on l'utilise)


    /**
     * Require ROLE_ADMIN for only this controller method.
     * 
     * @Route("/new", name="user_add")
     * @Route("/edit/{id}", name="user_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, User $user = null, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$user) {
            $user = new User();
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // par défaut on attribue le rôle user
            $user->setRoles(["ROLE_USER"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('users_index');
        }

        return $this->render('user/new.html.twig', [
            'formAddUser' => $form->createView(),
            'editMode' => $user->getId() !== null
        ]);
    }
}
