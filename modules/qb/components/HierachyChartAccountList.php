<?php

namespace app\modules\qb\components;

use app\modules\qb\models\ChartAccount;

class HierachyChartAccountList
{
    public $options;
    public $mainAccount;

    public function setmainAccount(): HierachyChartAccountList
    {
        $this->mainAccount = ChartAccount::getmainAccount();
        return $this;
    }

    public function setOptions(): HierachyChartAccountList
    {
        foreach ($this->mainAccount as $class) {

            $classAccount = [
                'id' => $class->account_number,
                'label' => $class->name,
            ];

            if (ChartAccount::hasSubAccount($class->account_number))
                $classAccount['children'] = $this->createChildrenArray($class->account_number);


            $this->options[] = $classAccount;
        }

        return $this;
    }

    public function createChildrenArray($parent_id): array
    {
        $list = [];
        foreach (ChartAccount::getSubAccount($parent_id) as $group) {

            if (ChartAccount::hasSubAccount($group['id']))
                $group['children'] = $this->createChildrenArray($group['id']);

            $list[] = $group;
        }
        return $list;
    }

    public function get(): array
    {
        return $this->options ?? [];
    }
}