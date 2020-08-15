<?php

namespace SocymSlim\Monopoly\entities;

class Player
{

    private $id;
    private $playerName;
    private $playerTotalAsset;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPlayerName(): ?String
    {
        return $this->playerName;
    }

    public function setPlayerName(?String $playerName): void
    {
        $this->playerName = $playerName;
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
