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
            
        }else{
            $nextPage = null;
        }

        if(strlen($prevLink) == 49){
            $prevPage = intval(substr($prevLink, -1), 10);
        }elseif(strlen($prevLink) == 50){
            $prevPage = intval(substr($prevLink, -2), 10);
        }else{
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
        $result = $callApiService->getCharacterById($id);
        $originLink = $result['origin']['url'];
        
        if(strlen($originLink) == 42){
            $linkPlanet = intval(substr($originLink, -1), 10);
        }elseif(strlen($originLink) == 43){
            $linkPlanet = intval(substr($originLink, -2), 10);
        }else{
            $linkPlanet = null;
        }

        return $this->render('character/show.html.twig', [
            'character' => $result,
            'link_origin' => $linkPlanet
        ]);
    }
}
