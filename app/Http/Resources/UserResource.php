<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
		$carbonToday = Carbon::today()->toDateString();

        return [
            "id" => $this->id,
            "name" => $this->name,
            "totalOrders" => $this->orders()->count(),
			"totalOrdersToday" => $this->orders()->whereDate("created_at", $carbonToday)->count(),
			"totalOrdersPaid" => $this->orders()->where("status", "paid")->sum("total_value"),
            "invoiceArears" => $this->orders()->where("status", "pending")->sum("total_value"),
        ];
    }
}
