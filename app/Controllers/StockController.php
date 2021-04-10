<?php

namespace App\Controllers;

use App\Services\StockBuyRequest;
use App\Services\stockBuyService;
use InvalidArgumentException;
use Twig\Environment;

class StockController

{
    private StockBuyService $stockBuyService;
    private Environment $twig;

    public function __construct(StockBuyService $stockBuyService, Environment $twig)
    {
        $this->stockBuyService = $stockBuyService;
        $this->twig = $twig;
    }

    public function index(): void
    {
        echo 'HOME';
        $this->twig->display('base.twig');
        $this->stockBuyService->get();
    }


    public function buyStocks(): void
    {
        echo 'BUY';
        $this->twig->display('BuyStocksView.twig');

        if (isset($_POST['buy'])) {
            try {
                $symbol = $_POST['symbol'];
                $amount = $_POST['amount'];

                if (!ctype_alpha($symbol)) {
                    throw new InvalidArgumentException('Invalid symbol.');
                }
                if (!ctype_digit($amount)) {
                    throw new InvalidArgumentException('Invalid amount.');
                } else {
                    $stock = new StockBuyRequest(
                        $symbol,
                        $amount,
                    );
                    $this->stockBuyService->save($stock);
                    //       $this->twig->display('messages.twig', ['message' => $this->messages->registerMessage($person)]);
                }
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage();
            }
        }

    }
}
