<?php

namespace App\Services;

use App\Models\Stock;
use App\Repositories\StockRepository;

class StockBuyService
{
    private StockRepository $stockRepository;

    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function save(StockBuyRequest $request):Stock
    {
        $stock = new Stock(
            $request->getSymbol(),
            $request->getAmount()
        );

        $this->stockRepository->store($stock);
        return $stock;

    }

    public function get(): void
    {
       $this->stockRepository->select();
    }

}