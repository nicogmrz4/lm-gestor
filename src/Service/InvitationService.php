<?php

namespace App\Service;

use App\Entity\MasterLeague;
use App\Entity\MasterLeagueInvitation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class InvitationService
{
    const GENERATE_SUCCESS_MSG_FORMAT = 'La invitación ha sido generada correctamente, recuerda que solo dura 24hrs.<br>👉 %s';
    const USE_SUCCESS_MSG_FORMAT = 'Te has unido correctamente a <b>%s</b>.';

    public function __construct(
        private EntityManagerInterface $em,
        private Security $security
    ) {}

    public function generateInvitation(MasterLeague $masterLeague): string
    {
        $token = bin2hex(random_bytes(32));

        $invitation = new MasterLeagueInvitation;
        $invitation->setToken($token);
        $invitation->setMasterLeague($masterLeague);
        $invitation->setUsed(false);
        $invitation->setExpirationDate(new \DateTimeImmutable('+1 day'));

        $this->em->persist($invitation);
        $this->em->flush();

        return $token;
    }

    public function deleteInvitation(MasterLeagueInvitation $invitation): void
    {
        $this->em->remove($invitation);
        $this->em->flush();
    }

    public function getInvitationByToken(string $token): ?MasterLeagueInvitation
    {
        return $this->em
            ->getRepository(MasterLeagueInvitation::class)
            ->findOneBy(['token' => $token]);
    }

    public function validateInvitation(MasterLeagueInvitation $invitation): void
    {
        if ($invitation->getExpirationDate() < new \DateTimeImmutable()) {
            throw new \Exception('Invitation expired');
        }

        if ($invitation->isUsed()) {
            throw new \Exception('Invitation already used');
        }
    }

    public function useInvitation(MasterLeagueInvitation $invitation): void
    {
        $user = $this->security->getUser();
        $masterLeague = $invitation->getMasterLeague();
        $masterLeague->addUser($user);
        $this->em->flush();
    }
}
