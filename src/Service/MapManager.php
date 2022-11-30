<?php

namespace App\Service;

use App\Repository\TileRepository;

class MapManager
{
    public function __construct(private TileRepository $tileRepository)
    {
        $this->tileRepository = $tileRepository;
    }

    public function tileExists(int $x, int $y): bool
    {
        $tile = $this->tileRepository->findOneBy(['coordX' => $x, 'coordY' => $y]);
        return ($tile) ? true : false;
    }
}
