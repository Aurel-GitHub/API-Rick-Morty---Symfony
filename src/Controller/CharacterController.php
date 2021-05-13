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
        $result = $callApiService->getResultByPage(CallApiService::CHARACTER, $page);
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
        $result = $callApiService->getResultById(CallApiService::CHARACTER, $id);
        $originLink = $result['origin']['url'];
        $locationLink = $result['location']['url'];
        
        if(strlen($originLink) == 42 ){
            $linkPlanet = intval(substr($originLink, -1), 10);
        }elseif(strlen($originLink) == 43){
            $linkPlanet = intval(substr($originLink, -2), 10);
        }else{
            $linkPlanet = null;
        }

        if(strlen($locationLink) == 42 ){
            $linkEart = intval(substr($locationLink, -1), 10);
        }elseif(strlen($locationLink) == 43){
            $linkEart = intval(substr($locationLink, -2), 10);
        }else{
            $linkEart = null;
        }

        $arrayLink = [];
        foreach($result['episode'] as $key => $link){
            if(strlen($link) == 41){
                $linkEpisode = intval(substr($link, -1), 10);
                $arrayLink[] = $linkEpisode;
            }elseif(strlen($link) == 42){
                $linkEpisode = intval(substr($link, -2), 10);
                $arrayLink[] = $linkEpisode;
            }elseif(strlen($link) == 43){
                $linkEpisode = intval(substr($link, -3), 10);
                $arrayLink[] = $linkEpisode;
            }else{
                $linkEpisode= null;
            }
        }

        return $this->render('character/show.html.twig', [
            'character' => $result,
            'link_origin' => $linkPlanet,
            'link_location' =>$linkEart,
            'results' => $arrayLink

        ]);
    }
}
