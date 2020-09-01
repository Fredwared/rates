<?php

namespace App\Services;
use Illuminate\Support\Facades\Cache;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use App\Rates;

use Carbon\Carbon;

class RatesService {

    /**
     * @var ExchangeRate
     */
    protected $service;

    /**
     * @var Rates
     */
    protected $model;

    /**
     * RatesService constructor.
     * @param ExchangeRate $service
     * @param Rates $ratesModel
     */
    public function __construct(ExchangeRate $service, Rates $ratesModel){
        $this->service = $service;
        $this->model = $ratesModel;
    }

    /**
     * Cache all currencies
     *
     * @return mixed $array
     */
    public function getAll(){
        return Cache::remember("currencies:all", 36000, function (){
            return $this->service->currencies();
        });
    }

    /**
     * @param string $currency
     * @return string
     */
    public function get($currency = 'USD'){
        return Cache::get("currencies:{$currency}", function () use ($currency){
            $this->getAll();

            return $this->getRate($currency);
        });
    }

    /**
     * @return string
     */
    public function getFlatten(){
        return implode(',', $this->getAll());
    }

    /**
     * @param $currency
     * @param $to
     * @return array
     */
    public function getRate($currency, $to){
        return Cache::remember("currencies:{$currency}:{$to}", 3600, function () use ($currency, $to) {
            $value = $this->service->exchangeRate($currency, $to, Carbon::now());

            return $this->model->create([
                'from'  => $currency,
                'to'    => $to,
                'value' => round($value, 4)
            ]);
        });
    }

    /**
     * History of rates
     * @return mixed
     */
    public function getHistory(){
        return Rates::all();
    }
}
