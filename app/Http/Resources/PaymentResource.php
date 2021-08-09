<?php

namespace App\Http\Resources;

use App\Http\Resources\Summaries\DealSummaryResource;
use App\Http\Resources\Summaries\UserSummaryResource;
use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    use HasJsonResource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'amount' => $this->amount,
            'transaction_id' => $this->transaction_id,
            'user' => new UserSummaryResource($this->user),
            'deal' => new DealSummaryResource($this->deal),
        ];
    }
}
