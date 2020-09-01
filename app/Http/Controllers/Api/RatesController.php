<?php

/**
 * @SWG\Swagger(
 *     basePath="/api/",
 *     schemes={"http", "https"},
 *     host=L5_SWAGGER_CONST_HOST,
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Rates API",
 *         description="Rates API description",
 *         @SWG\Contact(
 *             email="fredwared@gmail.com"
 *         ),
 *     )
 * )
 */

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Rates as RatesResource;
use App\Services\RatesService;
use Validator;

class RatesController extends Controller
{
    protected $service;

    public function __construct(RatesService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Get(
     *      path="/exchange-currencies",
     *      tags={"Доступные валюты"},
     *      operationId="RatesController@index",
     *      summary="Список доступных валют",
     *      description="",
     *
     *      @SWG\Response(
     *          response=200,
     *          description="[json]"
     *       )
     *     )
     *
     */
    public function index(){
        return $this->service->getAll();
    }


    /**
     * @SWG\Get(
     *      path="/exchange-rates",
     *      tags={"Текущие курсы указанной валюты"},
     *      operationId="RatesController@getRate",
     *      summary="Текущие курсы указанной валюты",
     *      description="",
     *
     *      @SWG\Parameter(
     *          name="rateOf",
     *          in="query",
     *          required=true,
     *          type="string"
     *      ),
     *
     *      @SWG\Parameter(
     *          name="to",
     *          in="query",
     *          required=false,
     *          type="string"
     *      ),
     *
     *      @SWG\Response(
     *          response=200,
     *          description="[json]"
     *       )
     *     )
     *
     *  @param Request $request
     *  @return mixed
     *
     */
    public function getRate(Request $request){
        $validator = Validator::make($request->all(), [
            'rateOf' => "required|in:{$this->service->getFlatten()}|max:4",
            'to'     => "sometimes|in:{$this->service->getFlatten()}|max:4|different:rateOf"
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 422);
        }

        $to = $request->has('to') ? $request->to : 'USD';

        return $this->service->getRate($request->input('rateOf'), $to);
    }



    /**
     * @SWG\Get(
     *      path="/exchange-rates/history",
     *      tags={"История изминение цен"},
     *      operationId="RatesController@history",
     *      summary="История изминение цен",
     *      description="",
     *
     *      @SWG\Response(
     *          response=200,
     *          description="[json]"
     *       )
     *     )
     *
     * Rates history
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     */
    public function history(){
        return RatesResource::collection($this->service->getHistory());
    }
}
