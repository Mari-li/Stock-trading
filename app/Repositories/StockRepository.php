<?php

namespace App\Repositories;

use App\Models\Stock;

interface StockRepository
{
    public function store(Stock $stock): void;

}