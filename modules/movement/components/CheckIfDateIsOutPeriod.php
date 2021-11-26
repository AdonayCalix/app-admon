<?php

namespace app\modules\movement\components;

use app\modules\project\models\ProjectPeriod;

class CheckIfDateIsOutPeriod
{

    private $currentDate;
    private $date;
    private $projectId;
    private $periodIdSuchCurrentDate;
    private $periodIdSuchDate;

    public function __construct(string $date, int $projectId)
    {
        $this->date = $date;
        $this->projectId = $projectId;
        $this->currentDate = date('Y-m-d');
    }

    public function setPeriodSuchCurrentDate(): CheckIfDateIsOutPeriod
    {
        $this->periodIdSuchCurrentDate = ProjectPeriod::getPeriodByDate($this->currentDate , $this->projectId);
        return $this;
    }

    public function setPeriodSuchDate(): CheckIfDateIsOutPeriod
    {
        $this->periodIdSuchDate = ProjectPeriod::getPeriodByDate($this->date , $this->projectId);
        return $this;
    }

    public function result(): bool
    {
        return  $this->periodIdSuchCurrentDate == $this->periodIdSuchDate;
    }
}