<?php

namespace App\Controller;

use App\Services\CallApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CharacterController extends AbstractController
{
    /**
     * @Route("/characters/{page}", name="characters")
     */
    public function index(CallApiService $callApiService, int $page): Response
    {
        $result = $callApiService->getCharactersByPage($page);
        $nextLink = $result['info']['next'];
        $prevLink = $result['info']['prev'];
        
    
        if(strlen($nextLink) == 49){
            $nextPage = intval(substr($nextLink, -1), 10);
        }elseif(strlen($nextLink) == 50){
            $nextPage = intval(substr($nextLink, -2), 10);
            
        }elseif(!$nextLink){
            $nextPage = null;
        }

        if(strlen($prevLink) == 49){
            $prevPage = intval(substr($prevLink, -1), 10);
        }elseif(strlen($prevLink) == 50){
            $prevPage = intval(substr($prevLink, -2), 10);
        }elseif (!$prevLink) {
            $prevPage = null;
        }

        return $this->render('character/index.html.twig', [
            'characters' => $result,
            'next_page' => $nextPage,
            'prev_page' => $prevPage
        ]);
    }

    /**
     * @Route("/character/{id}", name="character_show")
     */
    public function show(CallApiService $callApiService, int $id): Response
    {
        return $this->render('character/show.html.twig', [
            'character' => $callApiService->getCharacterById($id),
        ]);
    }
}
