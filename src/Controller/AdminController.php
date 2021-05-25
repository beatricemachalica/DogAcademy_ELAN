<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        return $this->render('admin/index.html.twig', [
            // 'user' => '$this->getUser()->getUsername()',
        ]);
    }
    // IsGranted est une autre façon de controller l'accès des users
    // (ne pas oublier d'import la classe si on l'utilise)
}
