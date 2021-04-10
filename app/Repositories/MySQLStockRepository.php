<?php


namespace App\Repositories;

use App\Config;
use App\Models\Stock;
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
            'amount' => $stock->getAmount()
        ]);
    }

    public function select(): void
    {
        $result = $this->db->select($this->table, ['symbol', 'amount']);

    }


}