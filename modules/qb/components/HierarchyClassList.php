<?php

namespace app\modules\qb\components;

use app\modules\qb\models\ListClass;

class HierarchyClassList
{
    public $options;
    public $mainClasses;

    public function setMainClasses(): HierarchyClassList
    {
        $this->mainClasses = ListClass::getMainClasses();
        return $this;
    }

    public function setOptions(): HierarchyClassList
    {
        foreach ($this->mainClasses as $class) {

            $classValues = [
                'id' => $class->identifier,
                'label' => $class->name,
            ];

            if (ListClass::hasSubClasses($class->identifier))
                $classValues['children'] = $this->createChildrenArray($class->identifier);


            $this->options[] = $classValues;
        }

        return $this;
    }

    public function createChildrenArray($parent_id): array
    {
        $list = [];
        foreach (ListClass::getSubClasses($parent_id) as $group) {

            if (ListClass::hasSubClasses($group['id']))
                $group['children'] = $this->createChildrenArray($group['id']);

            $list[] = $group;
        }
        return $list;
    }

    public function get(): array
    {
        return $this->options;
    }
}