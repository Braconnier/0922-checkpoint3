<?php

namespace App\Controller;

use App\Entity\Tile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BoatRepository;
use App\Repository\TileRepository;
use App\Service\MapManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class MapController extends AbstractController
{
    #[Route('/map', name: 'map')]
    public function displayMap(BoatRepository $boatRepository, TileRepository $tileRepository, MapManager $mapManager): Response
    {

        $tiles = $tileRepository->findAll();
        foreach ($tiles as $tile) {
            $map[$tile->getCoordX()][$tile->getCoordY()] = $tile;
        }

        $boat = $boatRepository->findOneBy([]);
        $boatX = $boat->getCoordX();
        $boatY = $boat->getCoordY();
        $tile = $tileRepository->findOneBy(['coordX' => $boatX, 'coordY' => $boatY]);
        $checkTreasure = $mapManager->checkTreasure($tile);
        if ($checkTreasure) {
            $this->addFlash('success', 'Congrats you found the treasure !');
        }
        return $this->render('map/index.html.twig', [
            'map'  => $map ?? [],
            'boat' => $boat,
            'tile' => $tile
        ]);
    }
    #[Route('/start', name: 'start')]
    public function start(BoatRepository $boatRepository, MapManager $mapManager, EntityManagerInterface $em)
    {
        $boat = $boatRepository->findOneBy(['id' => 1]);
        $boat->setCoordX(0);
        $boat->setCoordY(0);
        $em->flush();
        $mapManager->resetTreasure();
        $setRandomTreasure = $mapManager->getRandomIsland();
        $setRandomTreasure->setHasTreasure(true);
        $em->persist($setRandomTreasure);
        $em->flush();

        return $this->redirectToRoute('map');
    }
}
