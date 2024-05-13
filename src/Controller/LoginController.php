<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(
        Request $request, 
        UserRepository $userRepository, 
        UserPasswordHasherInterface $passwordHasher, 
        Security $security): Response
    {
        $user = $this->getUser();

        if (!is_null($user)) return $this->redirectToRoute('ml_home');
        $loginForm = $this->createForm(LoginType::class, null, [
            'action' => $this->generateUrl('app_login'),
            'method' => 'POST',
        ]);

        $loginFormErrors = '';

        $loginForm->handleRequest($request);
        
        if ($loginForm->isSubmitted() && $loginForm->isValid()) {
            $userIdentifier = $loginForm->getData()['username'];
            $user = $userRepository->findByEmailOrUsername($userIdentifier);
            $plaintextPassword = $loginForm->getData()['password'];

            if (is_null($user) || !$passwordHasher->isPasswordValid($user, $plaintextPassword)) {
                $loginForm->addError(new FormError('Credenciales incorrectas'));
            } else return $security->login($user); 
        }

        return $this->render('login/index.html.twig', [
            'loginForm' => $loginForm,
            'loginFormErrors' => $loginFormErrors
        ]);
    }
}
