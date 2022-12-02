<?php

namespace App\Controller;

use App\Repository\BoatRepository;
use App\Service\MapManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/boat')]
class BoatController extends AbstractController
{
    #[Route('/move/{x}/{y}', name: 'moveBoat', requirements: ['x' => '\d+', 'y' => '\d+'])]
    public function moveBoat(int $x, int $y, BoatRepository $boatRepository, EntityManagerInterface $em): Response
    {
        $boat = $boatRepository->findOneBy([]);
        $boat->setCoordX($x);
        $boat->setCoordY($y);
        $em->flush();
        return $this->redirectToRoute('map');
    }

    #[Route('/direction/{direction}', name: 'boatDirection', requirements: ['N' => '\w', 'S' => '\w', 'W' => '\w', 'E' => '\w'])]
    public function moveDirection(string $direction, BoatRepository $boatRepository, EntityManagerInterface $em, MapManager $mapManager): Response
    {
        $boat = $boatRepository->findOneBy([]);
        $boat =  match ($direction) {
            'N' => $boat->setCoordY($boat->getCoordY() - 1),
            'S' => $boat->setCoordY($boat->getCoordY() + 1),
            'W' => $boat->setCoordX($boat->getCoordX() - 1),
            'E' => $boat->setCoordX($boat->getCoordX() + 1),
        };
        $tileTest = $mapManager->tileExists($boat->getCoordX(), $boat->getCoordY());
        if ($tileTest) {
            $em->flush();
        } else {
            $this->addFlash('warning', 'The sea map isn\'t that big !');
        }
        return $this->redirectToRoute("map");
    }
}
