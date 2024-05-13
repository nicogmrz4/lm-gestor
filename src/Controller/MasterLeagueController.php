<?php

namespace App\Controller;

use App\Entity\MasterLeague;
use App\Form\MasterLeaguePlayerCardRuleType;
use App\Form\MasterLeaguePlayerPriceRuleType;
use App\Form\MasterLeagueType;
use App\Repository\MasterLeaguePlayerCardRuleRepository;
use App\Repository\MasterLeaguePlayerPriceRuleRepository;
use App\Repository\MasterLeagueRepository;
use App\Service\MasterLeagueService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MasterLeagueController extends AbstractController
{
    public function __construct(
        private MasterLeagueRepository $masterLeagueRepository,
        private MasterLeaguePlayerCardRuleRepository $masterLeaguePlayerCardRuleRepository,
        private MasterLeaguePlayerPriceRuleRepository $masterLeaguePlayerPriceRuleRepository,
        private EntityManagerInterface $em,
        private MasterLeagueService $masterLeagueService,
    ) {}

    #[Route('/', name: 'ml_home')]
    public function index(): Response
    {
        $masterLeague = new MasterLeague;
        
        $newMLForm = $this->createForm(MasterLeagueType::class, $masterLeague, [
            'action' => $this->generateUrl('create_ml'),
        ]);

        $allMls = $this->masterLeagueRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'newMLForm' => $newMLForm,
            'allMls' => $allMls
        ]);
    }

    #[Route('/master-league', name: 'create_ml', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $masterLeague = new MasterLeague;
        
        $newMLForm = $this->createForm(MasterLeagueType::class, $masterLeague);
        $newMLForm->handleRequest($request);

        if ($newMLForm->isSubmitted() && $newMLForm->isValid()) {
            $this->masterLeagueService->saveMasterLeague($masterLeague);
            $this->addFlash('success', MasterLeagueService::ML_CREATED_SUCCESS_MSG);
        }
        
        return $this->redirectToRoute('ml_home');
    }
   
    #[Route('/master-league/{id}', name: 'view_ml', methods: ['GET'])]
    public function view(int $id): Response
    {
        $masterLeague = $this->masterLeagueRepository->find($id);

        return $this->render('master_league/view.html.twig', [
            'ml' => $masterLeague
        ]);
    }

    #[Route('/master-league/{id}/edit', name: 'edit_ml')]
    public function edit(Request $request, int $id): Response
    {
        $masterLeague = $this->masterLeagueRepository->find($id);

        $editMLForm = $this->createForm(MasterLeagueType::class, $masterLeague, [
            'action' => $this->generateUrl('edit_ml', [
                'id' => $id
            ]),
        ]);

        $editMLForm->handleRequest($request);

        if ($editMLForm->isSubmitted() && $editMLForm->isValid()) {
            $this->masterLeagueService->updateMasterLeague($masterLeague);
            $this->addFlash('success', $this->masterLeagueService::ML_UPDATE_SUCCESS_MSG);
            return $this->redirectToRoute('ml_home');
        }

        return $this->render('master_league/edit.html.twig', [
            'master_league' => $masterLeague,
            'editMLForm' => $editMLForm
        ]);
    }

    #[Route('/master-league/{id}/rules', name: 'ml_rules', methods: ['GET'])]
    public function rules(MasterLeague $masterLeague): Response
    {
        $playerCardRules = $masterLeague->getPlayerCardRules()->toArray();
        usort($playerCardRules, function ($a, $b) {
            return $b->getPrice() <=> $a->getPrice();
        });
        $playerPriceRules = $masterLeague->getPlayerPriceRules()->toArray();
        usort($playerPriceRules, function ($a, $b) {
            return $b->getPrice() <=> $a->getPrice();
        });

        $playerCardRuleForm = $this->createForm(
            MasterLeaguePlayerCardRuleType::class,
            null,
            [
                'action' => $this->generateUrl('edit_ml_player_card_rule', [
                    'masterLeagueId' => $masterLeague->getId(),
                ]),
            ]
        );

        $playerPriceRuleForm = $this->createForm(
            MasterLeaguePlayerPriceRuleType::class,
            null,
            [
                'action' => $this->generateUrl('create_ml_player_price_rule', [
                    'masterLeagueId' => $masterLeague->getId(),
                ]),
            ]
        );

        return $this->render('master_league/rules/index.html.twig', [
            'ml' => $masterLeague,
            'playerCardRuleForm' => $playerCardRuleForm,
            'playerPriceRuleForm' => $playerPriceRuleForm,
            'playerCardRules' => $playerCardRules,
            'playerPriceRules' => $playerPriceRules
        ]);
    }
}
