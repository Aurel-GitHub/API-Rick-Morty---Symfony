<?php

namespace App\Controller;

use App\Services\CallApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EpisodesController extends AbstractController
{
    /**
     * @Route("/episodes/{page}", name="episodes")
     */
    public function index(CallApiService $callApiService, int $page): Response
    {
        $result = $callApiService->getResultByPage(CallApiService::EPISODE, $page);
        $nextLink = $result['info']['next'];
        $prevLink = $result['info']['prev'];

        if(strlen($nextLink) == 47){
            $nextPage = intval(substr($nextLink, -1), 10);
        }elseif(strlen($nextLink) == 48){
            $nextPage = intval(substr($nextLink, -2), 10);
        }else{
            $nextPage = null;
        }

        if(strlen($prevLink) == 47){
            $prevPage = intval(substr($prevLink, -1), 10);
        }elseif(strlen($prevLink) == 48){
            $prevPage = intval(substr($prevLink, -2), 10);
        }else{
            $prevPage = null;
        }

        return $this->render('episode/index.html.twig', [
             'episodes' => $result,
            'next_page' => $nextPage,
            'prev_page' => $prevPage        
        ]);
    }

    /**
     * @Route("/episode/{id}", name="episode_show")
     */
    public function show(CallApiService $callApiService, int $id): Response
    {
        $result = $callApiService->getResultById(CallApiService::EPISODE, $id);

        $arrayLink = [];
        foreach($result['characters'] as $key => $link){
            if(strlen($link) == 43){
                $linkCharacter = intval(substr($link, -1), 10);
                $arrayLink[] = $linkCharacter;
            }elseif(strlen($link) == 44){
                $linkCharacter = intval(substr($link, -2), 10);
                $arrayLink[] = $linkCharacter;
            }elseif(strlen($link) == 45){
                $linkCharacter = intval(substr($link, -3), 10);
                $arrayLink[] = $linkCharacter;
            }else{
                $linkCharacter= null;
            }
        }

        return $this->render('episode/show.html.twig', [
            'episode' => $result,
             'results' => $arrayLink
        ]);
    }

}
