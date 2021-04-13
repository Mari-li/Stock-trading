<?php


namespace App\Models;


class StockCollection
{
    /**
     * @var Stock[]
     */
    private array $stocks = [];


    public function add(Stock $stock): void
    {
        $this->stocks[] = new Stock(
            $stock->getSymbol(),
            $stock->getAmount(),
            $stock->getPrice(),
            $stock->getValue()
        );
    }


    public function all(): array
    {
        return $this->stocks;
    }


    public function one(string $symbol): Stock
    {
        foreach ($this->stocks as $one) {
            if ($one->getSymbol() === $symbol) {
                $stock = $one;
            }
        }
        return $stock;
    }


}