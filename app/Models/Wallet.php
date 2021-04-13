<?php


namespace App\Models;


class Wallet
{
    private float $money;

    public function __construct()
    {
        $json = file_get_contents('/mnt/c/projects/stock-trading/app/Utils/wallet.json');
        $this->money = json_decode($json, true)['money'];
    }

    public function getMoney(): float
    {
        return $this->money;
    }


    public function setMoney(float $changes): void
    {
        $newMoney = $this->money += $changes;
        $money = json_encode(['money' => $newMoney]);
        file_put_contents('/mnt/c/projects/stock-trading/app/Utils/wallet.json', $money);
    }


}