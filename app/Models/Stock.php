<?php

namespace App\Models;


class Stock
{
    private string $symbol;
    private int $amount;
    private float $price;
    private string $date;


    public function __construct(string $symbol, int $amount, float $price)
    {
        $this->symbol = $symbol;
        $this->amount = $amount;
        $this->price = $price;
        $this->setDate();
    }


    public function getSymbol(): string
    {
        return $this->symbol;
    }


    public function getAmount(): int
    {
        return $this->amount;
    }


    public function getPrice(): float
    {
        return $this->price;
    }


    public function getDate(): string
    {
        return $this->date;
    }


    public function setDate(): void
    {
        $this->date = date('Y-m-d H:i:s');
    }

}