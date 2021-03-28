<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Event;
use App\Form\CommentairesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentController extends AbstractController
{
    /**
     * Permet de créer un commentaire sur un event passe en id
     * @Route("/creerComment/{id}",name="creerComment")
     */
    public function addComment(int $id,Request $request, UserInterface $user)
    {
        //Cree le formulaire pour le commentaire
        $comment = new Commentaire();
        $form = $this->createForm(CommentairesType::class,$comment);
        $form->handleRequest($request);

        //Si le formulaire a été rempli et validé
        if ($form->isSubmitted() && $form->isValid()) {
            //relie le commentaire a l'utilisateur qui l'a créé
            $comment->setEmail($user->getUsername());
            //passe le commentaire en actif (pour être affiché)
            $comment->setActif(true);
            //initialise le commentaire à la date de la créatiob
            $comment->setcreated_at(new \DateTime('now'));
           
            //cherche l'event qui corresponds au commentaire grace à l'id passé en paramètre
            $entityManager = $this->getDoctrine()->getManager();
            $event=$entityManager->getRepository(Event::class)->find($id);
            $comment->setEvent($event);
            //envoie le commentaire dans la base de donnée
            $entityManager->persist($comment);
            $entityManager->flush();
            //redirige vers la liste des events
            return $this->redirectToRoute('event');
        }
        //Renvoie vers la page affichant le formulaire du commentaire
        return $this->render('comment/add.html.twig',[
            'registrationForm'=>$form->createView()
        ]);
    }

    /**
     * Affiche tous les commentaires d'un event dont l'id est passé en paramètres
     * @Route("/afficherComment/{id}",name="afficherComment")
     */
    function showComment(int $id,Request $request)
    {
        //Cherche avec la fonction findBy de doctrine tous les commentaires dont l'id est celui passé en paramètres
        //Et trie ses commentairs pas date de création
        $donnees = $this->getDoctrine()->getRepository(Commentaire::class)->findBY([
            'event'=>$id
        ],['created_at'=>'desc']);
        //retourne la page d'affichage avec en paramètre la liste des commentaires trouvés
        return $this->render('comment/index.html.twig',[
            'comments'=>$donnees
        ]);
    }

}
