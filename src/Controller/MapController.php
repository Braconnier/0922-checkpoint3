<?php

namespace App\Controller;

use App\Entity\Tile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BoatRepository;
use App\Repository\TileRepository;
use App\Service\MapManager;

class MapController extends AbstractController
{
    #[Route('/map', name: 'map')]
    public function displayMap(BoatRepository $boatRepository, TileRepository $tileRepository, MapManager $mapManager): Response
    {

        $tiles = $tileRepository->findAll();
        $setRandomTreasure = $mapManager->getRandomIsland();
        $tile = new Tile;
        $tile->setHasTreasure(array_rand($setRandomTreasure));
        foreach ($tiles as $tile) {
            $map[$tile->getCoordX()][$tile->getCoordY()] = $tile;
        }

        $boat = $boatRepository->findOneBy([]);
        $bX = $boat->getCoordX();
        $bY = $boat->getCoordY();
        $tile = $tileRepository->findOneBy(['coordX' => $bX, 'coordY' => $bY]);
        return $this->render('map/index.html.twig', [
            'map'  => $map ?? [],
            'boat' => $boat,
            'tile' => $tile
        ]);
    }
}
