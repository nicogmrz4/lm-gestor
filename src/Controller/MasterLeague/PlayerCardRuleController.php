<?php

namespace App\Controller\MasterLeague;

use App\Entity\MasterLeaguePlayerCardRule;
use App\Form\MasterLeaguePlayerCardRuleType;
use App\Repository\MasterLeaguePlayerCardRuleRepository;
use App\Service\MasterLeagueService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlayerCardRuleController extends AbstractController
{
    public function __construct(
        private MasterLeagueService $masterLeagueService,
        private MasterLeaguePlayerCardRuleRepository $masterLeaguePlayerCardRuleRepository
    ) {}

    #[Route('/master-league/{masterLeagueId}/player-card-rules', name: 'create_ml_player_card_rule', methods: ['POST'])]
    public function createPlayerCardRule(Request $request, int $masterLeagueId): Response
    {
        $playerCardRule = new MasterLeaguePlayerCardRule;
        $playerCardRuleForm = $this->createForm(MasterLeaguePlayerCardRuleType::class, $playerCardRule);
        $playerCardRuleForm->handleRequest($request);

        if ($playerCardRuleForm->isSubmitted() && $playerCardRuleForm->isValid()) {
            $this->masterLeagueService->savePlayerCardRule($playerCardRule, $masterLeagueId);
            $this->addFlash('success', 'Se ha creado la regla con exito');
        }

        return $this->redirectToRoute('ml_rules', [
            'id' => $masterLeagueId,
        ]);
    }

    #[Route('/master-league/{masterLeagueId}/player-card-rules/{id}', name: 'edit_ml_player_card_rule', methods: ['POST'])]
    public function editPlayerCardRule(Request $request, int $masterLeagueId, int $id = null): Response
    {
        $playerCardRule = $this->masterLeaguePlayerCardRuleRepository->find($id);
        $playerCardRuleForm = $this->createForm(MasterLeaguePlayerCardRuleType::class, $playerCardRule);
        $playerCardRuleForm->handleRequest($request);

        if ($playerCardRuleForm->isSubmitted() && $playerCardRuleForm->isValid()) {
            $this->masterLeagueService->updatePlayerCardRule($playerCardRule);
            $this->addFlash('success', MasterLeagueService::RULE_UPDATED_SUCCESS_MSG);
        }

        return $this->redirectToRoute('ml_rules', [
            'id' => $masterLeagueId,
        ]);
    }

    #[Route('/master-league/{masterLeagueId}/player-card-rules/{id}/delete', name: 'delete_ml_player_card_rule', methods: ['POST'])]
    public function deletePlayerCardRule(Request $request, int $masterLeagueId, int $id = null): Response
    {
        $submittedToken = $request->getPayload()->get('token');

        if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
            $this->masterLeagueService->deletePlayerCardRule($id);
            $this->addFlash('success', MasterLeagueService::RULE_DELETED_SUCCESS_MSG);
        }

        return $this->redirectToRoute('ml_rules', [
            'id' => $masterLeagueId,
        ]);
    }
}
