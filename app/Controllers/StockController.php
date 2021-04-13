<?php

namespace App\Controllers;

use App\Models\Wallet;
use App\Services\StockBuyRequest;
use App\Services\stockBuyService;
use App\Services\StockPortfolioService;
use App\Services\StockSellService;
use InvalidArgumentException;
use Twig\Environment;

class StockController

{
    private StockBuyService $stockBuyService;
    private StockPortfolioService $stockListService;
    private StockSellService $stockSellService;
    private Wallet $wallet;
    private Environment $twig;

    public function __construct(StockBuyService $stockBuyService,
                                StockPortfolioService $stockListService,
                                StockSellService $stockSellService,
                                Wallet $wallet,
                                Environment $twig)
    {
        $this->stockBuyService = $stockBuyService;
        $this->stockListService = $stockListService;
        $this->stockSellService = $stockSellService;
        $this->wallet = $wallet;
        $this->twig = $twig;
    }


    public function buyStocks(): void
    {
        if (isset($_POST['buy'])) {
            try {
                $symbol = strtoupper($_POST['symbol']);
                $amount = $_POST['amount'];
                $price = $this->stockBuyService->getCurrentPrice($symbol);

                if (!ctype_alpha($symbol)) {
                    throw new InvalidArgumentException('Invalid symbol.');
                }
                if (!ctype_digit($amount)) {
                    throw new InvalidArgumentException('Invalid amount.');
                } else {
                    $stock = new StockBuyRequest(
                        $symbol,
                        $amount,
                        $price,
                    );
                    $this->stockBuyService->add($stock);
                    $this->wallet->setMoney(-($amount * $price));
                }
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage();
            }
        }
        header('Location:/');
    }


    public function showStockPortfolio(): void
    {
        $stocks = $this->stockListService->getStockPortfolioInfo();
        $this->twig->display('PortfolioView.twig', ['stocks' => $stocks, 'wallet' => $this->wallet->getMoney()]);
    }


    public function sellStocks(): void
    {
        $request = $_POST['sell'];
        // $stock =  $this->stockSellService->getStock($stock);
        $newPrice = $this->stockBuyService->getCurrentPrice($request);
        $this->stockSellService->sell($request);
        $this->wallet->setMoney($newPrice);
        header('Location:/');
    }
}
