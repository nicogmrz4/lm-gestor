<?php

namespace App\Controller\MasterLeague;

use App\Entity\MasterLeaguePlayerPriceRule;
use App\Form\MasterLeaguePlayerPriceRuleType;
use App\Repository\MasterLeaguePlayerPriceRuleRepository;
use App\Service\MasterLeagueService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlayerPriceRuleController extends AbstractController
{
    public function __construct(
        private MasterLeagueService $masterLeagueService,
        private MasterLeaguePlayerPriceRuleRepository $masterLeaguePlayerPriceRuleRepository
    ) {}
    #[Route('/master-league/{masterLeagueId}/player-price-rules', name: 'create_ml_player_price_rule', methods: ['POST'])]
    public function createPlayerPriceRule(Request $request, int $masterLeagueId): Response
    {
        $playerPriceRule = new MasterLeaguePlayerPriceRule;
        $playerPriceRuleForm = $this->createForm(MasterLeaguePlayerPriceRuleType::class, $playerPriceRule);
        $playerPriceRuleForm->handleRequest($request);
        
        if (!$this->masterLeagueService->isValidPlayerPriceRule($playerPriceRule)) {
            $this->addFlash('error', $this->masterLeagueService->formatPlayerCardRuleRangeError($playerPriceRule));
        } else if ($playerPriceRuleForm->isSubmitted() && $playerPriceRuleForm->isValid()) {
            $this->masterLeagueService->savePlayerPriceRule($playerPriceRule, $masterLeagueId);
            $this->addFlash('success', MasterLeagueService::RULE_CREATED_SUCCESS_MSG);
        }

        return $this->redirectToRoute('ml_rules', [
            'id' => $masterLeagueId,
        ]);
    }    
    
    #[Route('/master-league/{masterLeagueId}/player-price-rules/{id}', name: 'edit_ml_player_price_rule', methods: ['POST'])]
    public function editPlayerPriceRule(Request $request, int $masterLeagueId, int $id = null): Response
    {
        $playerPriceRule = $this->masterLeaguePlayerPriceRuleRepository->find($id);
        $playerPriceRuleForm = $this->createForm(MasterLeaguePlayerPriceRuleType::class, $playerPriceRule);
        $playerPriceRuleForm->handleRequest($request);

        if (!$this->masterLeagueService->isValidPlayerPriceRule($playerPriceRule)) {
            $this->addFlash('error', $this->masterLeagueService->formatPlayerCardRuleRangeError($playerPriceRule));
        } else if ($playerPriceRuleForm->isSubmitted() && $playerPriceRuleForm->isValid()) {
            $this->masterLeagueService->updatePlayerPriceRule($playerPriceRule);
            $this->addFlash('success', MasterLeagueService::RULE_UPDATED_SUCCESS_MSG);
        }
        
        return $this->redirectToRoute('ml_rules', [
            'id' => $masterLeagueId,
        ]);
    }

    #[Route('/master-league/{masterLeagueId}/player-price-rules/{id}/delete', name: 'delete_ml_player_price_rule', methods: ['POST'])]
    public function deletePlayerPriceRule(Request $request, int $masterLeagueId, int $id = null): Response
    {
        $submittedToken = $request->getPayload()->get('token');

        if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
            $this->masterLeagueService->deletePlayerPriceRule($id);
            $this->addFlash('success', MasterLeagueService::RULE_DELETED_SUCCESS_MSG);
        }

        return $this->redirectToRoute('ml_rules', [
            'id' => $masterLeagueId,
        ]);
    }
}