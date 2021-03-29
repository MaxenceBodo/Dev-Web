<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * Permet de se connecter
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        //Si il y a déja un utilisateur de connecté renvoie vers homme
        //empeche la double authentification
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // Crée l'erreur de connection si il y en a 
        $error = $authenticationUtils->getLastAuthenticationError();
        // Dernier nom saisie par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();
        //Renvoie vers la page de connection
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * Permet de se deconnecter
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
