<?php

namespace SocymSlim\Monopoly\entities;

class Player
{

    private $id;
    private $name;
    private $totalAsset;

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

    public function getTotalAsset(): ?int
    {
        return $this->totalAsset;
    }

    public function setTotalAsset(?int $totalAsset): void
    {
        $this->totalAsset = $totalAsset;
    }
}
