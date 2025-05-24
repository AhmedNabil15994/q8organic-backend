<?php

namespace Modules\DriverApp\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class UnknownOrderAddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'receiver_name' => $this->receiver_name,
            'receiver_mobile' => $this->receiver_mobile,
            'state_id' => $this->state_id,
            'state' => optional($this->state)->title,
            'city' => optional(optional($this->state)->city)->title,
        ];
    }
}
