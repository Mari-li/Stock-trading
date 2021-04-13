<?php


namespace App\Services;


class StockBuyRequest
{
    private string $symbol;
    private int $amount;
    private float $price;

    public function __construct(string $symbol, int $amount, float $price)
    {
        $this->symbol = $symbol;
        $this->amount = $amount;
        $this->price = $price;
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


}