<?php

namespace App\Controller;

use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function register(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name')
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password'],
            ])
            ->add('register', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-lg btn-primary-green float-right'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $this->userService->createUser($data);
            return $this->redirect($this->generateUrl('home'));
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function registerView()
    {
        $form = $this->createFormBuilder()
            ->add('name')
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password'],
            ])
            ->add('register', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-lg btn-primary-green float-right'
                ]
            ])
            ->getForm();

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
