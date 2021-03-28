<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Liste les differents utilisateurs et commentaires afficher sur le site afin de pouvoir les gérer
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="utilisateurs")
     */
    public function usersList(UserRepository $users, EventRepository $event)
    {
        return $this->render('admin/users.html.twig', [
            'users' => $users->findAll(),
            'events' => $event->findAll()
        ]);
    }

    /**
     * permet la modificifation d'un utilisateur
     * @Route("/utilisateurs/modifier/{id}", name="modifier_utilisateur")
     */
    public function editUser(User $user, Request $request, TranslatorInterface $translator)
    {
        //creer un formulaire pour l'edition d'utilisateur
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        //Rentre dans le if une fois que le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            //permet d appeler les fonctions permettant de gerer la base de donnees
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $message = $translator->trans('Utilisateur modifié avec succès');
            $this->addFlash('message', $message);
            
            //Une fois les modifications faites renvoies vers la page d'acceuil des administrateurs
            return $this->redirectToRoute('admin_utilisateurs');
        }
        
        //renvoie vers la page de modification d'un utilisateurs avec en argument le formulaire
        return $this->render('admin/edituser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    //---------DELETE
    /**
     * Supprimer un utilisateur, il n'est pas possible de se supprimer soi-meme
     * @Route("/deleteUser/{id}",name="delete_utilisateur")
     */
    public function deleteUser(int $id): Response
    {
        //trouve l'utilisateur avec l'id passé en paramètre et appelle la fonction remove
        //pour l'enlever de la base de donnee
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute("event");
    }
}
