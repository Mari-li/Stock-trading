<?php

namespace App\Services;

use App\Models\Stock;
use App\Repositories\FinnhubRepository;
use App\Repositories\StockRepository;

class StockBuyService
{
    private StockRepository $stockRepository;
    private FinnhubRepository $finnHub;

    public function __construct(StockRepository $stockRepository, FinnhubRepository $finnHub)
    {
        $this->stockRepository = $stockRepository;
        $this->finnHub = $finnHub;
    }


    public function add(StockBuyRequest $request): void
    {
        $stock = new Stock(
            $request->getSymbol(),
            $request->getAmount(),
            $request->getPrice(),
        );

        $this->stockRepository->store($stock);

    }


    private function checkIfExist(string $request): bool
    {
        if (count($this->stockRepository->select($request)) == 1) {
            return true;
        }
        return false;
    }


    public function getCurrentPrice(string $request): float
    {
        return $this->finnHub->getCurrentPrice($request);
    }


}