<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Event;
use App\Entity\EventSearch;
use App\Form\EventSearchType;
use App\Form\EventType;
use App\Repository\EventRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;



class EventController extends AbstractController
{
    //---------READ
    /**
     * Permet l'affichage des evenements
     * @Route("/event", name="event")
     */
    public function index(Request $request, PaginatorInterface $paginator, EventRepository $repositoty) : Response // Nous ajoutons les paramètres requis
    {
        //Permet la recherche d'évenements, utilise l'entité EventSearch
        $search = new EventSearch();
        $form = $this->createForm(EventSearchType::class, $search);
        $form->handleRequest($request);

        //Tableau des events triés selon un critère passé dans EventSearch (cf : App\Entity\EventSearch et App\Repository\EventRepository)
        $eventSeach = $repositoty->findAllBySearch($search);
        
        //La fonction paginate est un bundle permettant d'afficher les evenements par page 
        $event = $paginator->paginate(
            $eventSeach, // Requête contenant les données à paginer (ici nos events)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
        
        //Renvoie vers l'affichage avec en paramètre la liste d'event et le formulaire de recherche
        return $this->render('event/index.html.twig', [
            'events' => $event,
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
        //cree le formulaire permettant la création d'un evenement
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        
        //Si le formulaire est validé et correctement rempli
        if ($form->isSubmitted() && $form->isValid()) {
            
            //l'attribut user de event est innitialisé avec l'utilisateur connecté
            $event->setCreateur($user);

            //Grace à doctrine l'event est envoyé dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        //Renvoie à l'affichage avec en commentaire le formulaire de création
        return $this->render('event/add.html.twig',[
            'registrationForm'=>$form->createView()
        ]);
    }

    //---------UPDATE
    /**
     * Permet de modifier un event dont l'id est passé en paramètre
     * @Route("/modifEvent/{id}",name="editerEvent")
     */
    public function modifyEvent(Request $request, int $id, TranslatorInterface $translator): Response
    {
        //Cherche l'evenement correspondant à l'id en paramètre
        $entityManager = $this->getDoctrine()->getManager();
        $event = $entityManager->getRepository(Event::class)->find($id);

        //Cree le formulaire pour la modification d'evenement
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        //Si le formulaire est validé et correctement rempli
        if($form->isSubmitted() && $form->isValid())
        {
            //l'event est envoyé dans la base de donnée
            $entityManager->flush();
            //permet de traduire le message
            $message = $translator->trans('Event modifié avec succès');
            $this->addFlash('message', $message);
            //L'utilisateur est renvoyé vers la liste des events
            return $this->redirectToRoute('event');
        }

        //renvoie vers l'affichage du formulaire avec le formulaire passé en paramètre
        return $this->render("event/editerEvent.html.twig", [
            "form_product" => $form->createView(),
        ]);
    }    

    //---------DELETE
    /**
     * Permet de supprimer un event
     * @Route("/deleteEvent/{id}",name="deleteEvent")
     */
    public function deleteProduct(int $id): Response
    {
        //Trouve grace à doctrine l'event dont l'id est passé en paramètre et le supprime de la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $event = $entityManager->getRepository(Event::class)->find($id);
        $entityManager->remove($event);
        $entityManager->flush();

        //Renvoie vers la liste des events
        return $this->redirectToRoute("event");
    }
}