<?php

namespace App\Controller;

use App\Services\CallApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CharacterController extends AbstractController
{
    /**
     * 
     * TODO pour faire la page s insipirer de show/{id} et y mettre les pages 
     * ici la page est à 0 par défaut 
     * le faire incréementer  
     */
    /**
     * @Route("/characters/{page}", name="characters")
     */
    public function index(CallApiService $callApiService, int $page): Response
    {
        $result = $callApiService->getAllCharacters();
        $nextLink = $result['info']['next'];
        $prevLink = $result['info']['prev'];
    

        if(strlen($nextLink) == 48){
            $nextPage = intval(substr($nextLink, -1));
        }elseif(strlen($nextLink) == 49){
            $nextPage = intval(substr($nextLink, -2));
        }elseif(!$nextLink){
            $nextPage = null;
        }

        if(strlen($prevLink) == 48){
            $prevPage = intval(substr($prevLink, -1));
        }elseif(strlen($prevLink) == 49){
            $prevPage = intval(substr($prevLink, -2));
        }elseif (!$prevLink) {
            $prevPage = null;
        }

        return $this->render('character/index.html.twig', [
            'characters' => $callApiService->getCharactersByPage($page),
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
