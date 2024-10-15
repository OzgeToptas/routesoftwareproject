<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name'            => $this->first_name,
            'last_name'             => $this->last_name,
            'email'                 => $this->email,
            'shipping_address'      => $this->shipping_address,
            'billing_address'       => $this->billing_address,
            'fulfillment_status'    => $this->fulfillment_status,
            'payment_status'        => $this->payment_status,
            'SKU'                   => optional($this->cart)->SKU,
            'item_name'             => optional($this->cart)->item_name,
            'item_parts'            => optional($this->cart)->item_parts,
            'item_parts_quantity'   => optional($this->cart)->item_parts_quantity,
            'item_part_prices'      => optional($this->cart)->item_part_prices,
            'grand_total'           => optional($this->cart)->grand_total,
        ];
    }
}
