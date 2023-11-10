<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Get Orders
        // $items = [];

        // foreach ($this->order_ids as $orderId) {
        // Fetch Order
        // $order = Order::find($orderId);

        // array_push($items, $order);
        // }

        return [
            "id" => $this->id,
            "invoice_number" => $this->invoice_number,
            "items" => $this->items,
            "amount" => $this->amount,
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
