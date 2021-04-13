<?php


namespace App\Repositories;

use App\Config;
use App\Models\Stock;
use App\Models\StockCollection;
use Medoo\Medoo;


class MySQLStockRepository implements StockRepository
{
    private Medoo $db;
    private string $table = 'stocks';

    public function __construct()
    {
        $dbConfig = Config::getInstance()->get('db');
        $this->db = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'stock_trading',
            'server' => 'localhost',
            'username' => $dbConfig['user'],
            'password' => $dbConfig['password']
        ]);

    }


    public function store(Stock $stock): void
    {
        $this->db->insert($this->table, [
            'symbol' => $stock->getSymbol(),
            'amount' => $stock->getAmount(),
            'price' => $stock->getPrice()
        ]);
    }


    public function select(string $request): array
    {
        $stocks = $this->db->select($this->table, ['symbol', 'amount', 'price'], ['symbol' => $request]);
        var_dump($stocks);
        return $stocks;

    }


    public function update(Stock $stock): void
    {
        $this->db->update($this->table, ['amount[+]' => $stock->getAmount()], ['symbol' => $stock->getSymbol()]);
    }


    public function selectAll(): array
    {
        return $this->db->select($this->table, ['symbol', 'amount', 'price']);
    }


    public function selectBySymbol(string $symbol): StockCollection
    {
        $dbStocks = $this->db->select($this->table, ['symbol', 'amount', 'price'], ['symbol' => $symbol]);
        $stocks = new StockCollection();
        foreach ($dbStocks as $dbStock)
        {
            $stocks->add(
                new Stock(
                    $dbStock['symbol'],
                    $dbStock['amount'],
                    $dbStock['price'],
                    $dbStock['price'],

                )
            );
        }
        var_dump($stocks);
        return $stocks;
    }


    public function delete(string $stock): void
    {
        $this->db->delete($this->table, ['symbol' => $stock]);
    }

}