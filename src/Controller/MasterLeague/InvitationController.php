<?php

namespace App\Controller\MasterLeague;

use App\Entity\MasterLeague;
use App\Entity\MasterLeagueInvitation;
use App\Service\InvitationService;
use App\Service\MasterLeagueService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class InvitationController extends AbstractController
{
    public function __construct(
        private InvitationService $invitationService
    ) {}

    #[Route('/master-league/{id}/invitation/create', name: 'create_ml_invitation', methods: ['GET'])]
    public function create(Request $request, MasterLeague $masterLeague): Response
    {
        $token = $this->invitationService->generateInvitation($masterLeague);
        $useLink = $this->generateUrl('use_ml_invitation', [
           'token' => $token
        ], UrlGeneratorInterface::ABSOLUTE_URL);
        
        $message = sprintf(
            InvitationService::GENERATE_SUCCESS_MSG_FORMAT,
            $useLink
        );

        $this->addFlash('success', $message);

        return $this->redirectToRoute('view_ml', [
            'id' => $masterLeague->getId()
        ]);
    }

    #[Route('/invitation/{token}', name: 'use_ml_invitation', methods: ['GET'])]
    public function use(MasterLeagueInvitation $masterLeagueInvitation): Response
    {
        try {
            $this->invitationService->validateInvitation($masterLeagueInvitation);
            $this->invitationService->useInvitation($masterLeagueInvitation);
            $message = sprintf(
                InvitationService::USE_SUCCESS_MSG_FORMAT, 
                $masterLeagueInvitation->getMasterLeague()->getTitle()
            );
            $this->addFlash('success', $message);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
        }

        return $this->redirectToRoute('view_ml', [
            'id' => $masterLeagueInvitation->getMasterLeague()->getId()
        ]);
    }
}
