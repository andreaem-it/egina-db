<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ImpostazioniController extends AbstractController
{
    /**
     * @Route("/impostazioni", name="impostazioni")
     */
    public function index()
    {
        return $this->redirectToRoute('impostazioni_generali');
    }

    /**
     * @Route("/impostazioni/generali", name="impostazioni_generali")
     */
    public function generalAction() {

        return $this->render('impostazioni/generali.html.twig');
    }

    /**
     * @Route("/impostazioni/utenti", name="impostazioni_utenti")
     */
    public function userAction() {

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('impostazioni/utenti.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/impostazioni/utenti/add", name="impostazioni_utenti_add")
     */
    public function userAddAction(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response {

        $user = New User();

        $form = $this->createFormBuilder($user)
            ->add('username')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->add('roles', CollectionType::class, [
                'label' => 'User Roles',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'prototype' => true,
                'attr' => [
                    'class' => 'selector'
                ]
            ])
            ->add('submit',SubmitType::class)
            ->getForm()
        ;

        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $em->persist($user);
            $em->flush();

            $this->redirectToRoute('impostazioni_utenti');
        }

        return $this->render('impostazioni/utenti.edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/impostazioni/utenti/edit/{id}", name="impostazioni_utenti_edit")
     */
    public function userEditAction(Request $request, $id, UserPasswordEncoderInterface $passwordEncoder): Response {

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $form = $this->createFormBuilder($user)
            ->add('username')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->add('roles', CollectionType::class, [
                'label' => 'User Roles',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'prototype' => true,
                'attr' => [
                    'class' => 'selector'
                ],
                'required' => false
            ])
            ->add('submit',SubmitType::class)
            ->getForm()
        ;

        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $em->flush();

            $this->redirectToRoute('impostazioni_utenti');
        }

        return $this->render('impostazioni/utenti.edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
