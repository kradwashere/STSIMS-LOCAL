<?php

namespace App\Http\Resources\Accounting;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    public function toArray($request)
    {
        $allotment = ($this->allotments_sum_amount) ? $this->allotments_sum_amount : '0.00';
        $disbursement = ($this->disbursements_sum_amount) ? $this->disbursements_sum_amount : '0.00';
        $add = ($this->add_sum_amount) ? $this->add_sum_amount : '0.00';
        $minus = ($this->minus_sum_amount) ? $this->minus_sum_amount : '0.00';

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'balance' => $this->amount,
            'expenditure' => $this->expenditure,
            'is_active' => $this->is_active,
            'total' => $allotment + $add - $minus,
            'allotment' => $allotment,
            'disbursement' => $disbursement,
            'add' => $add,
            'minus' => $minus
        ];
    }
}
