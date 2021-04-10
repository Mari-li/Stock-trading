<?php

namespace App\Models;


class Stock
{
    private string $symbol;
    private int $amount;
//    private float $price;
//    private float $value;


    public function __construct(string $symbol, int $amount)
    {
        $this->symbol = $symbol;
        $this->amount = $amount;

    }


    public function getSymbol(): string
    {
        return $this->symbol;
    }


    public function getAmount(): int
    {
        return $this->amount;
    }


    public function getValue(): float
    {
        return $this->value;
    }


    public function getPrice(): float
    {
        return $this->price;
    }

}