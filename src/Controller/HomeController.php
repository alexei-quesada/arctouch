<?php

namespace App\Controller;

use App\Services\EventService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $eventService;

    public function __construct(EventService $eventService) {
        $this->eventService = $eventService;
    }

    /**
     * @Route("/", name="home")
     * @return Response
     * @throws Exception
     */
    public function index()
    {
        $upcomingEvents = $this->eventService->findUpcomingEvents();
        return $this->render('home/home.html.twig', [
            'events' => $upcomingEvents
        ]);
    }

}
