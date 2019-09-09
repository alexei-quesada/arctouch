<?php

namespace App\Services;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class EventService
{
    private $userRepository;
    private $eventRepository;
    private $distanceService;
    private $em;

    /**
     * EventService constructor.
     * @param EventRepository $eventRepository
     * @param UserRepository $userRepository
     * @param DistanceService $distanceService
     * @param EntityManagerInterface $em
     */
    public function __construct(EventRepository $eventRepository, UserRepository $userRepository, DistanceService $distanceService,  EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->eventRepository = $eventRepository;
        $this->distanceService = $distanceService;
        $this->em = $em;
    }

    /**
     * @param $userId
     * @param $eventId
     * @param $userLocation [latitude:value, longitude:value]
     */
    public function rsvp($eventId, $userId, $userLocation){
        $event = $this->eventRepository->find($eventId);
    }

    /**
     * @param $orderBy
     * @param $limit
     * @param $offset
     * @return Event[]
     */
    public function findAllPaginatedOrderBy($orderBy, $limit, $offset){
        return $this->eventRepository->findBy([], $orderBy, $limit, $offset);
    }

    /**
     * @param $slug
     * @return Event|null
     */
    public function findOneBySlug($slug){
        return $this->eventRepository->findOneBy(array('slug'=>$slug));
    }


    /**
     * @return mixed
     * @throws Exception
     */
    public function findUpcomingEvents(){
        return $this->eventRepository->findUpcomingEvents(new \DateTime());
    }

    /**
     * @param $eventSlug
     * @param $userId
     * @param $userLocation
     * @return bool
     */
    public function joinEvent($eventSlug, $userId, $userLocation){
        $event = $this->findOneBySlug($eventSlug);
        if($event){
            $coordinates = explode(",", $event->getLocation());
            $eventLatitude = floatval($coordinates[0]);
            $eventLongitude = floatval($coordinates[1]);

            $user = $this->userRepository->find($userId);
            $userLatitude = floatval($userLocation['lat']);
            $userLongitude = floatval($userLocation['lon']);

            $distanceToEvent = $this->distanceService->getDistanceFromTwoPoints($eventLatitude,$eventLongitude, $userLatitude, $userLongitude, 'M');
            $event->addAttendee($user);
            $this->em->flush();
            return $distanceToEvent <= 20;

        }else{
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getTotalEvents(){
        return $this->eventRepository->count(array());
    }



}