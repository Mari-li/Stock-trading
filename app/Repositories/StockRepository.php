<?php

namespace App\Repositories;

use App\Models\Stock;
use App\Models\StockCollection;

interface StockRepository
{
    public function store(Stock $stock): void;

    public function select(string $request): array;

    public function update(Stock $stock): void;

    public function delete(string $stock):void;

    public function selectBySymbol(string $symbol): StockCollection;

}