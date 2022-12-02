<?php

namespace App\Service;

use App\Entity\Tile;
use App\Repository\TileRepository;
use Doctrine\ORM\EntityManagerInterface;

class MapManager
{
    public function __construct(private TileRepository $tileRepository, EntityManagerInterface $em)
    {
        $this->tileRepository = $tileRepository;
        $this->em = $em;
    }

    public function tileExists(int $x, int $y): bool
    {
        $tile = $this->tileRepository->findOneBy(['coordX' => $x, 'coordY' => $y]);
        return ($tile) ? true : false;
    }
    public function getRandomIsland(): Tile
    {
        $islandTiles = $this->tileRepository->findBy(['type' => 'island']);
        $randomIslandKey = array_rand($islandTiles, 1);
        $randomIsland = $islandTiles[(int)$randomIslandKey];
        return $randomIsland;
    }
    public function resetTreasure(): void
    {
        $islandTiles = $this->tileRepository->findBy(['type' => 'island']);

        foreach ($islandTiles as $islandTile) {
            $islandTile->setHasTreasure(false);
            $this->em->persist($islandTile);
        }
        $this->em->flush();
    }
    public function checkTreasure($tile): bool
    {
        return ($tile->getHasTreasure());
    }
}
