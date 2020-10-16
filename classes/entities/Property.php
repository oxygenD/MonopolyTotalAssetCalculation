<?php

namespace SocymSlim\Monopoly\entities;

class Property
{

    // 物件ID
    private $propertyId;
    // 物件名
    private $name;
    // 銀行から購入する際の価格
    private $basicPrice;
    // プレイヤーとの紐づけに用いる
    private $playerID;

    public function getPropertyId(): ?int
    {
        return $this->propertyId;
    }

    public function setPropertyId(?int $propertyId): void
    {
        $this->propertyId = $propertyId;
    }

    public function getName(): ?String
    {
        return $this->name;
    }

    public function setName(?String $name): void
    {
        $this->name = $name;
    }

    public function getBasicPrice(): ?int
    {
        return $this->basicPrice;
    }

    public function setBasicPrice(?int $basicPrice): void
    {
        $this->basicPrice = $basicPrice;
    }

    public function getPlayerID(): ?int
    {
        return $this->playerID;
    }

    public function setPlayerID(?int $playerID): void
    {
        $this->playerID = $playerID;
    }



}