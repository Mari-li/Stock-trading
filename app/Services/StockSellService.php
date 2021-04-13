<?php


namespace App\Services;

use App\Models\Stock;
use App\Repositories\StockRepository;

class StockSellService
{
    private StockRepository $stockRepository;

    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function sell(string $request): void
    {
        $this->stockRepository->delete($request);
    }

    public function getStock(string $request): Stock
    {
        return $this->stockRepository->selectBySymbol($request)->one($request);

    }

}