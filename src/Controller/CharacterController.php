<?php

namespace App\Controller;

use App\Services\CallApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CharacterController extends AbstractController
{
    /**
     * @Route("/personnage", name="characters")
     */
    public function index(CallApiService $callApiService): Response
    {
        return $this->render('character/index.html.twig', [
            'characters' => $callApiService->getAllCharacters(),
        ]);
    }

    /**
     * @Route("/personnage/{id}", name="character_show")
     */
    public function show(CallApiService $callApiService, int $id): Response
    {
        return $this->render('character/show.html.twig', [
            'character' => $callApiService->getCharacterById($id),
        ]);
    }
}
