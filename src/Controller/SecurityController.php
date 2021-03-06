<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\NewPasswordType;
use App\Entity\PasswordUpdate;
use Doctrine\ORM\EntityManager;
use App\Form\ChangePasswordType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Form\ForgottenPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('accueil');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/security/forgotten_Password", name="forgotten_password")
     */
    public function forgottenPassword(User $user = null, EntityManagerInterface $manager, Request $request, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, UserRepository $userRepository): Response
    {
        // on va instancier la variable form
        $form = $this->createForm(ForgottenPasswordType::class);

        $form->handleRequest($request);

        $email = $form->get('emailResetPassword')->getData();
        $user = $userRepository->findOneByEmail($email);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {

                // on g??n??re un token unique
                $token = $tokenGenerator->generateToken();
                try {
                    $user->setResetToken($token);
                    $manager->flush();
                } catch (\Exception $e) {
                    $this->addFlash('Warning', $e->getMessage());
                    return $this->redirectToRoute('app_login');
                }
                // on g??n??re une URL ayant une route qui va permettre de changer le mot de passe
                $url = $this->generateUrl('resetPassword', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

                // on envoie le mail
                $message = (new Email())
                    ->from('dogacademytestsymfony@gmail.com')
                    ->to($user->getEmail())
                    ->subject('DogAcad??mie mot de passe oubli??')
                    ->text("Voici le lien de r??cup??ration de votre mot de passe : " . $url, 'text/html')
                    ->html("<p> Ceci est un test : " . $url, 'text/html' . "</p>");

                $mailer->send($message);
                $this->addFlash('info', 'Le mail de r??cup??ration du mot de passe a bien ??t?? envoy??.');
            }
        }

        return $this->render('security/forgottenPassword.html.twig', [
            'form' => $form->createView(),
            'titre' => "R??initialisation du mot de passe"
        ]);
    }
    /**
     * Mot de passe oubli??
     * 
     * @Route("resetPassword/{token}", name="resetPassword")
     */
    public function resetPassword(User $user = null, EntityManagerInterface $manager, Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository): Response
    {
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        // on va red??finir le user
        $user = $userRepository->findOneByResetToken($token);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {

                // on va effacer le token car il va ??tre utilis?? pour reset le mdp
                $user->setResetToken(NULL);
                // on r??cup??re le mdp dans l'input du form
                $newPassword = $form->get('password')->getData();
                // on set le nouveau password
                $user->setPassword(
                    $passwordEncoder->encodePassword($user, $newPassword)
                );
                $manager->flush();
                // message add flash de confirmation
                $this->addFlash('info', 'Votre mot de passe a bien ??t?? r??initialis??.');
                return $this->redirectToRoute('app_login');
            }
        }
        return $this->render('security/resetPassword.html.twig', [
            'token' => $token,
            'form' => $form->createView(),
            'title' => "R??initialisation du mot de passe."
        ]);
    }

    /**
     * Pour modifier le mdp via le compte utilisateur
     * 
     * @IsGranted("ROLE_USER")
     * 
     * @Route("/passwordUpdate", name="update_password")
     */
    public function update_user_password(EntityManagerInterface $manager, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // Dans Symfony le $this->getUser permet de r??cup??rer le user connect??
        $user = $this->getUser();

        $passwordUpdate = new PasswordUpdate;

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on va v??rifier que l'ancien mdp du formulaire correspond bien ?? celui de l'utilisateur
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())) {
                // message d'erreur
                $form->get('old_password')->addError(new FormError("Le mot de passe n'est pas bon."));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $password = $passwordEncoder->encodePassword($user, $newPassword);

                $user->setPassword($password);

                $manager->persist($user);
                $manager->flush();

                // message add flash de confirmation
                $this->addFlash('info', 'Le mdp a bien ??t?? chang??.');
                return $this->redirectToRoute('user_index');
            }
        }

        return $this->render('security/updatePassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
