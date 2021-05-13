<?php

namespace App\Controller;

use App\Services\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    /**
     * @Route("/locations/{page}", name="locations")
     */
    public function index(CallApiService $callApiService, int $page): Response
    {
        $result = $callApiService->getLocationByPage($page);
        $nextLink = $result['info']['next'];
        $prevLink = $result['info']['prev'];

        if(strlen($nextLink) == 48){
            $nextPage = intval(substr($nextLink, -1), 10);
        }elseif(strlen($nextLink) == 49){
            $nextPage = intval(substr($nextLink, -2), 10);
        }else{
            $nextPage = null;
        }

        if(strlen($prevLink) == 48){
            $prevPage = intval(substr($prevLink, -1), 10);
        }elseif(strlen($prevLink) == 49){
            $prevPage = intval(substr($prevLink, -2), 10);
        }else{
            $prevPage = null;
        }

        return $this->render('location/index.html.twig', [
            'locations' => $result,
            'next_page' => $nextPage,
            'prev_page' => $prevPage
        ]);
    }

    /**
     * @Route("/location/{id}", name="location_show")
     */
    public function show(CallApiService $callApiService, int $id): Response
    {
        $result = $callApiService->getLocationById($id);

        $arrayLink = [];
        foreach($result['residents'] as $key => $link){
            if(strlen($link) == 43){
                $linkResident = intval(substr($link, -1), 10);
                $arrayLink[] = $linkResident;
            }elseif(strlen($link) == 44){
                $linkResident = intval(substr($link, -2), 10);
                $arrayLink[] = $linkResident;
            }elseif(strlen($link) == 45){
                $linkResident = intval(substr($link, -3), 10);
                $arrayLink[] = $linkResident;
            }else{
                $linkResident = null;
            }
        }

        return $this->render('location/show.html.twig', [
            'location' => $result,
            'results' => $arrayLink
        ]);
    }

    // /**
    //  * @Route("/character/{id}", name="character_show")
    //  */
    // public function show(CallApiService $callApiService, int $id): Response
    // {
    //     $result = $callApiService->getCharacterById($id);
    //     $originLink = $result['origin']['url'];
        
    //     if(strlen($originLink) == 42){
    //         $linkPlanet = intval(substr($originLink, -1), 10);
    //     }elseif(strlen($originLink) == 43){
    //         $linkPlanet = intval(substr($originLink, -2), 10);
    //     }elseif(!$originLink){
    //         $linkPlanet = null;
    //     }

    //     return $this->render('character/show.html.twig', [
    //         'character' => $result,
    //         'link_origin' => $linkPlanet
    //     ]);
    // }

}
