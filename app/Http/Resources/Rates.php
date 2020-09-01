<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Rates extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'currency'  => "{$this->from}/{$this->to}",
            'value' => $this->value,
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
