<?php

namespace App\Controller;

use App\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Event;
use App\Entity\EventSearch;
use App\Form\EventSearchType;
use App\Form\EventType;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Migrations\Query\Query;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Contracts\Translation\TranslatorInterface;


class EventController extends AbstractController
{
    //---------READ
    /**
     * @Route("/event", name="event")
     */
    public function index(Request $request, PaginatorInterface $paginator) : Response // Nous ajoutons les paramètres requis
    {
        $search = new EventSearch();
        $form = $this->createForm(EventSearchType::class, $search);
        $form->handleRequest($request);
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donneesEvent = $this->getDoctrine()->getRepository(Event::class)->findBy([],['date' => 'desc']);
        $donneesComent= $this->getDoctrine()->getRepository(Commentaire::class)->findBy([
            'email'=>$donneesEvent,
            'actif'=>1
        ],['created_at'=>'desc']);

        $event = $paginator->paginate(
            $donneesEvent, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
        
        return $this->render('event/index.html.twig', [
            'events' => $event,
            'comments' => $donneesComent,
            'form'=>$form->createView(),

        ]);
    }

    

    //---------CREATE
    /**
     * Creer un event 
     * @Route("/creerEvent",name="creerEvent")
     * 
     */
    public function addEvent(Request $request, UserInterface $user)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $event->setCreateur($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }


        return $this->render('event/add.html.twig',[
            'registrationForm'=>$form->createView()
        ]);
    }

    //---------UPDATE
    /**
     * Modifier un event
     * @Route("/modifEvent/{id}",name="editerEvent")
     */
    public function modifyEvent(Request $request, int $id, TranslatorInterface $translator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $event = $entityManager->getRepository(Event::class)->find($id);
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            $message = $translator->trans('Event modifié avec succès');
            $this->addFlash('message', $message);
            return $this->redirectToRoute('event');
        }

        return $this->render("event/editerEvent.html.twig", [
            "form_product" => $form->createView(),
        ]);
    }    

    //---------DELETE
    /**
     * Supprimer un event
     * @Route("/deleteEvent/{id}",name="deleteEvent")
     */
    public function deleteProduct(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $event = $entityManager->getRepository(Event::class)->find($id);
        $entityManager->remove($event);
        $entityManager->flush();

        return $this->redirectToRoute("event");
    }
}