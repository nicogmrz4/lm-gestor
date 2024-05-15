<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    const DELETE_SUCCESS = 'Se ha eliminado al usuario <b>%s</b> con exito'; 
    const CREATED_SUCCESS = 'Se ha creado el usuario <b>%s</b> con exito';
    const UPDATED_SUCCESS = 'Se ha actualizado el usuario <b>%s</b> con exito';

    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function createUser(User $user, $password, $isAdmin): void
    {
        if ($isAdmin) {
            $user->setRoles(['ROLE_ADMIN']);
        }
        $hashedPassword = $this->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function updateUser(User $user, $isAdmin): void
    {
        if ($isAdmin) { 
            $user->setRoles(['ROLE_ADMIN']);
        } else {
            $user->setRoles([]);
        }    
        $this->em->persist($user);
        $this->em->flush();
    }

    public function deleteUser(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function hashPassword(User $user, $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }
}