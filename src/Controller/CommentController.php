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
     * @Route("/comment", name="comment")
     */
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    /**
     * @Route("/creerComment/{id}",name="creerComment")
     */
    public function addComment(int $id,Request $request, UserInterface $user)
    {
        $comment = new Commentaire();
        $form = $this->createForm(CommentairesType::class,$comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setEmail($user->getUsername());
            $comment->setActif(true);
            $comment->setcreated_at(new \DateTime('now'));
           
            $entityManager = $this->getDoctrine()->getManager();
            $event=$entityManager->getRepository(Event::class)->find($id);
            $comment->setEvent($event);
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('event');
        }

        return $this->render('comment/add.html.twig',[
            'registrationForm'=>$form->createView()
        ]);
    }

    /**
     * @Route("/afficherComment/{id}",name="afficherComment")
     */
    function showComment(int $id,Request $request)
    {
        $donnees = $this->getDoctrine()->getRepository(Commentaire::class)->findBY([
            'event'=>$id
        ],['created_at'=>'desc']);
        return $this->render('comment/index.html.twig',[
            'comments'=>$donnees
        ]);
    }

}
