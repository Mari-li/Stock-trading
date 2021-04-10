<?php


namespace App\Repositories;

use App\Config;
use App\Models\Stock;
use PDO;


class PDOStockRepository implements StockRepository
{
    private PDO $pdo;
    private string $table = 'stocks';

    public function __construct()
    {
        $dbConfig = Config::getInstance()->get('db');
        $this->pdo = new PDO(
            'mysql:host=127.0.0.1;dbname=stock_trading',
            $dbConfig['user'],
            $dbConfig['password']
        );
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function store(Stock $stock): void
    {
        $symbol = $stock->getSymbol();
        echo $symbol;
        $amount = $stock->getAmount();
        echo $amount;
        $sql = $this->pdo->prepare("INSERT INTO stocks (symbol, amount) VALUES (?, ?)");
        var_dump($sql);
        $sql->execute([$symbol, $amount]);
    }

    public function select(): void
    {
        $rows = $this->pdo->query('SELECT * FROM stocks');
        foreach ($rows as $row) {
            var_dump($row);
        }
    }
}