<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private UserRepository $userRepository
    ) {}
    #[Route('/users', name: 'user_crud', methods: ['GET'])]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/users/create', name: 'create_user', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $user = new User;
        $userForm = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('create_user'),
        ]);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $roleAdmin = $userForm->get('roleAdmin')->getData();
            $password = $userForm->get('password')->getData();
            $this->userService->createUser($user, $password, $roleAdmin);
            $message = sprintf(UserService::CREATED_SUCCESS, $user->getUsername());
            $this->addFlash('success', $message);
            return $this->redirectToRoute('user_crud');
        }

        return $this->render('user/modals/user_modal.html.twig', [
            'userForm' => $userForm
        ]);
    }

    #[Route('/users/{id}/edit', name: 'edit_user', methods: ['POST'])]
    public function edit(Request $request, User $user): Response
    {
        $userForm = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('create_user'),
        ]);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $roleAdmin = $userForm->get('roleAdmin')->getData();
            $this->userService->updateUser($user, $roleAdmin);
            $message = sprintf(UserService::UPDATED_SUCCESS, $user->getUsername());
            $this->addFlash('success', $message);
        }
                
        return $this->redirectToRoute('user_crud');
    }    
    
    #[Route('/users/{id}/delete', name: 'delete_user', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        $submittedToken = $request->getPayload()->get('token');

        if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
            $this->userService->deleteUser($user);
            $message = sprintf(UserService::DELETE_SUCCESS, $user->getUsername());
            $this->addFlash('success', $message);  
        }
                
        return $this->redirectToRoute('user_crud');
    }
}
