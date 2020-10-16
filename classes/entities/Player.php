<?php

namespace SocymSlim\Monopoly\entities;

class Player
{

    private $id;
    private $name;
    private $totalAsset;
    private $inheritanceTax;

    // プレイ開始時の所持金額は一律1億5000万円。最低単位が10万円なので1500としている
    const FIRST_TOTAL_ASSET = 1500;
    // 相続税は全資産に対して、10%かかる
    const INHERITANCE_TAX = 0.1;


    public function __construct() {

        $this->totalAsset = self::FIRST_TOTAL_ASSET;
    }

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

    public function getInheritanceTax(): ?int
    {
        return ($this->totalAsset) * self::INHERITANCE_TAX;
    }

    public function setInheritanceTax(?int $inheritanceTax): void
    {
        $this->inheritanceTax = $inheritanceTax;
    }
}
