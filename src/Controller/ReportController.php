<?php

namespace App\Controller;

use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * @Route("/report", name="report.index")
     */
    public function index()
    {
        $users = $this->userService->findAllOrderBy(array('name'=>'ASC'));
        return $this->render('report/report.html.twig', [
            'users' => $users,
        ]);
    }
}
