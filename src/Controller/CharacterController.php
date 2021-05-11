<?php

namespace App\Controller;

use App\Services\CallApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CharacterController extends AbstractController
{
    /**
     * @Route("/personnage/son-nom", name="character")
     */
    public function index(CallApiService $callApiService): Response
    {
        return $this->render('character/index.html.twig', [
            'data' => $callApiService->getAllCharacters(),
        ]);
    }
}
