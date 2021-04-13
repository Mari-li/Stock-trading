<?php

namespace App\Services;

use App\Repositories\FinnhubRepository;
use App\Repositories\StockRepository;

class StockPortfolioService
{
    private FinnhubRepository $finnhub;
    private StockRepository $stockRepository;

    public function __construct(StockRepository $stockRepository, FinnhubRepository $finnhub)
    {
        $this->stockRepository = $stockRepository;
        $this->finnhub = $finnhub;
    }

    public function getStockPortfolioInfo(): array
    {
        $stockList = [];
        $savedStocks = $this->stockRepository->selectAll();

        foreach ($savedStocks as $savedStock) {
            $stockInfo = [];

            $stockInfo ['symbol'] = $savedStock['symbol'];
            $stockInfo ['amount'] = $savedStock['amount'];
            $stockInfo ['price'] = $savedStock['price'];
            $stockInfo ['totalPaid'] = $stockInfo ['price'] * $stockInfo ['amount'];
            $stockInfo ['value'] = $this->finnhub->getCurrentPrice($savedStock['symbol']);
            $stockInfo ['totalValue'] = $stockInfo ['value'] * $stockInfo ['amount'];
            $changes = ($stockInfo ['value'] - $stockInfo ['price']) / $stockInfo ['price'];
            $stockInfo ['changes'] = sprintf("%.2f%%", $changes * 100);
            $stockInfo ['companyName'] = $this->finnhub->getCompanyProfile($stockInfo ['symbol'])["name"];
            $stockInfo ['companyLogo'] = $this->finnhub->getCompanyProfile($stockInfo ['symbol'])["logo"];

            $stockList[] = $stockInfo;
        }
        return $stockList;
    }


}