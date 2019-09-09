<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact.index")
     */
    public function index(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name')
            ->add('email', EmailType::class)
            ->add('message', TextareaType::class)
            ->add('Submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-lg btn-primary-green float-right'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $this->addFlash('success', 'Message sent!');
            return $this->redirect($this->generateUrl('contact.index'));
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
