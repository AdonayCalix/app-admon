<?php

namespace app\modules\project\components;

use app\modules\project\models\base\ChartAccountActivity;
use app\modules\project\models\base\ChartAccountActivity as ChartAccountActivityAlias;
use app\modules\project\models\base\ClassActivity;
use app\modules\qb\models\base\ChartAccount;

class RelatedActivityWithQb
{
    private $post;

    public function __construct(array $post)
    {
        $this->post = $post;
    }

    public function store(): RelatedActivityWithQb
    {

        foreach ($this->post['AssignQb'] as $assigQb) {
            $this->storeClasses($assigQb['id'], $assigQb['classes'] ?? []);
            $this->storeChartAccounts($assigQb['id'], $assigQb['chart_accounts'] ?? []);
        }

        return $this;
    }

    public function storeClasses(int $activity_id, array $classes)
    {
        ClassActivity::deleteAll(['activity_id' => $activity_id]);

        foreach ($classes as $class) {
            $classActivity = new ClassActivity;
            $classActivity->activity_id = $activity_id;
            $classActivity->class_id = $class;
            $classActivity->save(false);
        }
    }

    public function storeChartAccounts(int $activity_id, array $chartAccounts)
    {
        ChartAccountActivityAlias::deleteAll(['activity_id' => $activity_id]);

        foreach ($chartAccounts as $chartAccount) {
            $chartAccountsActuvity = new ChartAccountActivity;
            $chartAccountsActuvity->activity_id = $activity_id;
            $chartAccountsActuvity->chart_account_id = $chartAccount;
            $chartAccountsActuvity->save(false);
        }
    }
}