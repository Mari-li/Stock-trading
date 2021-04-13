<?php

namespace App\Repositories;

use App\Config;
use Finnhub\Api\DefaultApi;
use Finnhub\Configuration;
use Finnhub\Model\CompanyProfile2;
use GuzzleHttp\Client;

class FinnhubRepository
{
    private DefaultApi $client;

    public function __construct()
    {
        $key = (Config::getInstance()->get('finnhubKey'));
        $config = Configuration::getDefaultConfiguration()->setApiKey('token', $key);
        $this->client = new DefaultApi(new Client(), $config);
    }

    public function getCurrentPrice(string $request): float
    {
        return $this->client->quote($request)['c'];
    }

    
    public function getCompanyProfile(string $symbol): CompanyProfile2
    {
        return $this->client->companyProfile2($symbol);

    }

}