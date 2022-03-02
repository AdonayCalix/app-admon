<?php

namespace app\modules\project\components\financial\formatv2\summary;

use phpDocumentor\Reflection\Types\This;

class SummarizeSource
{
    private $project_budget;

    public function __construct(array $project_budget)
    {
        $this->project_budget = $project_budget;
    }

    public function get(): array
    {
        $out = [];

        $first_row = 9;
        $last_row = 9;

        foreach ($this->project_budget as $budget) {

            $last_row = ($first_row + count($budget['activities'])) - 1;
            $out[] = ["", "{$budget['identifier']}. {$budget['name']}", "bold" => true, "italic" => true, "color" => "B00000"];

            foreach ($budget['activities'] as $activity) {
                $out[] = [
                    $activity['account_number'],
                    $activity['name'],
                    $activity['amount'],
                    "color" => "FFFFFF",
                    "alignment_horizontal" => "left"
                ];
            }

            $out[] = [
                "",
                "Total",
                "=SUM(C{$first_row}:C{$last_row})",
                "bold" => true,
                "color" => "B00000"
            ];

            $first_row = $last_row + 3;
        }

        //echo '<pre>' . print_r($out, true) . '</pre>';die;
        return $out;
    }
}