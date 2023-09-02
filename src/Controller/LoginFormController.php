<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginFormController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/login', name: 'app_login_form')]
    public function index(Request $request,UserPasswordHasherInterface $passwordHasher): Response
    {

        $form = $this->createForm(LoginFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mail = $form->get('email')->getData();
            $pass = $form->get('pass')->getData();

            $userRepository = $this->entityManager->getRepository(User::class);
            $user = $userRepository->findOneBy(['email' => $mail]);

            if (!$user) {
                echo 'Пользователь с такой почтой не найден';
            } elseif (!$this->isPasswordValid($passwordHasher, $user, $pass)) {
                echo 'Неверный пароль';
            } else {
                echo 'Пароль верный';
            }
        }
        return $this->render('login_form/index.html.twig', [
            'controller_name' => 'LoginFormController',
            'form' => $form,
            'test' => $pass,
        ]);
    }
    private function isPasswordValid(UserPasswordHasherInterface $passwordHasher, User $user, string $password): bool
    {
        return $passwordHasher->isPasswordValid($user, $password);
    }
}
