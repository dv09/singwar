<?php

namespace App\Controller;

use App\Managers\SignWarManagers\LookForTheStrongestManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Managers\SignWarManagers\SignBattleManager;

/**
 * @Route("/api/signwar", name="api_")
 */
class PlaySignWarController extends AbstractController
{
    /**
     * @Route("/play", methods={"POST"}, name="play_sign_war")
     * @param Request $request
     * @return JsonResponse
     */
    public function play(Request $request, SignBattleManager $playSignWar): JsonResponse
    {
        $requestContent = $request->getContent();
        $response = $playSignWar($requestContent)->manage();

        return new JsonResponse($response);
    }


    /**
     * @Route("/win", methods={"POST"}, name="win_sign_war")
     * @param Request $request
     * @return JsonResponse
     */
    public function win(Request $request, LookForTheStrongestManager $playSignWar): JsonResponse
    {
        $requestContent = $request->getContent();
        $response = $playSignWar($requestContent)->manage();

        return new JsonResponse($response);
    }
}
