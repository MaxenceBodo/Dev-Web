<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\User;
use App\Form\EditUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;


class UserController extends AbstractController
{

    /**
     * Permet de gérer le compte passé en id
     * @Route("/gererCompte/{id}", name="gererCompte")
     */
    public function gererCompte(int $id,User $user, Request $request, TranslatorInterface $translator)
    {
        //Cree le formulaire d'édition de client
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        $email = $this->getDoctrine()->getRepository(User::class)->find($id)->getEmail();
        $comments = $this->getDoctrine()->getRepository(Commentaire::class)->findBy(['email'=>$email]);

        //Si le formulaire est validé et correctement rempli
        if ($form->isSubmitted() && $form->isValid()) {
            //Envoie dans la base de donnée l'utilisateur modifié
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            //Affiche un message de modification et renvoie vers la page home
            $message = $translator->trans('Utilisateur modifié avec succès');
            $this->addFlash('message', $message);
            return $this->redirectToRoute('home');
        }
        //Renvoie vers la page d'édition avec le formulaire en paramètre
        return $this->render('user/editerProfil.html.twig', [
            'userForm' => $form->createView(),
            'comments' => $comments
        ]);
    }

    /**
     * Permet d'afficher les activités d'un utilisateur passé en ID
     * @Route("/mesActivites/{id}",name="gererSesActivites")
     */
    public function afficherMesEvent(int $id, UserInterface $user)
    {
        //Cherche grace à doctrine tous les evenements créé par un l'utilsateur passé en paramètre
        $donnes = $this->getDoctrine()->getRepository(Event::class)->findby(['createur'=>$id]);
        return $this->render('user/mesEvent.html.twig',[
            'mesEvent'=>$donnes
        ]);
    }
}
