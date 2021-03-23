<?php

namespace App\Controller;

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
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/gererCompte/{id}", name="gererCompte")
     */
    public function gererCompte(int $id,User $user, Request $request, TranslatorInterface $translator)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $message = $translator->trans('Utilisateur modifié avec succès');
            $this->addFlash('message', $message);
            return $this->redirectToRoute('home');
        }
        
        return $this->render('user/editerProfil.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/mesActivites/{id}",name="gererSesActivites")
     */
    public function afficherMesEvent(int $id, UserInterface $user)
    {
        $donnes = $this->getDoctrine()->getRepository(Event::class)->findby(['createur'=>$id]);
        return $this->render('user/mesEvent.html.twig',[
            'mesEvent'=>$donnes
        ]);
    }
}
