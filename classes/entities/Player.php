<?php

namespace SocymSlim\Monopoly\entities;

class Player
{

    private $id;
    private $name;
    private $playerTotalAsset;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?String
    {
        return $this->name;
    }

    public function setName(?String $name): void
    {
        $this->name = $name;
    }

    public function getPlayerTotalAsset(): ?int
    {
        return $this->playerTotalAsset;
    }

    public function setPlayerTotalAsset(?int $playerTotalAsset): void
    {
        $this->playerTotalAsset = $playerTotalAsset;
    }
}
