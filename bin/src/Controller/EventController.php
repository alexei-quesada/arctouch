<?php

namespace App\Controller;

use App\Services\EventService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EventController extends AbstractController
{
    private $eventService;
    private $urlGenerator;

    /**
     * EventController constructor.
     * @param EventService $eventService
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(EventService $eventService, UrlGeneratorInterface $urlGenerator) {
        $this->eventService = $eventService;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/events", name="event.index" )
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        $offset = 0;

        $totalEvents = $this->eventService->getTotalEvents();
        $totalPages = ceil($totalEvents/9);

        $page = $request->query->get('page');
        if($page && $page>0){
            $offset = ($page-1) * 9;
        }else{
            $page = 1;
        }
        $events = $this->eventService->findAllPaginatedOrderBy(array('date'=>'desc'),9, $offset);
        return $this->render('event/events.html.twig', [
            'events' => $events,
            'nbPages' => $totalPages,
            'currentPage' => $page,
            'url' => 'event.index'
        ]);
    }

    /**
     * @Route("/events/{slug}", name="event.show")
     * @param $slug
     * @return RedirectResponse|Response
     */
    public function showEvent($slug) {
        // if slug exist then find the event otherwise redirect to events page
        $event = $this->eventService->findOneBySlug($slug);
        if($event) {
            return $this->render('event/show.html.twig', [
                'event' => $event,
            ]);
        }
        return new RedirectResponse($this->urlGenerator->generate('event.index'));
    }


    /**
     * @Route("/events/{slug}/join", name="event.join", methods={"POST"})
     * @param $slug
     * @return RedirectResponse|Response
     */
   public function joinEvent($slug, Request $request){
        $userId = $request->request->get('userId');
        $userLocation = $request->request->get('userLocation');
        $response = new JsonResponse(['data' =>  $this->eventService->joinEvent($slug, $userId, $userLocation)]);
        return $response;
    }

}
