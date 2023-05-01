<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/utilisateur/edition/{id}', name: 'user.edit', methods:['GET', 'POST'])]
    public function edit(User $choosenUser, EntityManagerInterface $manager, Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(UserType::class, $choosenUser);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($hasher->isPasswordValid($choosenUser, $form->getData()->getPlainPassword()))
            {
                $user = $form->getData();

                $manager->persist($user);
                $manager->flush();
    
                $this->addFlash(
                    'success',
                    'Votre profil à bien été modifié !'
                );
    
                return $this->redirectToRoute('home.index');
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect'
                );
            }

        }

        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/utilisateur/edition-mot-de-passe/{id}', name: 'user.edit.password', methods:['GET', 'POST'])]
    public function editPassword(User $choosenUser, Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserPasswordType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($hasher->isPasswordValid($choosenUser, $form->getData()['plainPassword']))
            {
                $choosenUser->setUpdatedAt(new \DateTimeImmutable());
                $choosenUser->setPlainPassword(
                    $form->getData()['newPassword']
                );

                $manager->persist($choosenUser);
                $manager->flush();
    
                $this->addFlash(
                    'success',
                    'Votre mot de passe à été modifié avec succés'
                );
    
                return $this->redirectToRoute('home.index');
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect'
                );
            }
        }
        return $this->render('pages/user/edit_password.html.twig', [
            'form' => $form->createView(),
        ]); 
    }
}
