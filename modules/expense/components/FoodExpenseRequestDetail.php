<?php

namespace app\modules\expense\components;

class FoodExpenseRequestDetail
{
    private $expense_request_id;
    private $result;

    public function __construct(int $expense_request_id)
    {
        $this->expense_request_id = $expense_request_id;
    }

    public function make(): FoodExpenseRequestDetail
    {
        return $this;
    }

    public function get(): array
    {
        return $this->result;
    }
}