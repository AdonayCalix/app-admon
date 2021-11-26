<?php

namespace models;

use app\modules\movement\components\CheckIfDateIsOutPeriod;
use app\modules\project\models\ProjectPeriod;
use Codeception\Test\Unit;

class CheckIfDateIsOutPeriodTest extends Unit
{
    const DC2020_PROJECT_ID = 3;
    const DATE_FROM_Q1_DC2020 = '2021-09-10';
    const DATE_FROM_Q2_DC2020 = '2021-10-17';
    const DATE_FROM_Q3_DC2020 = '2021-11-23';

    public function testIfDateIsFromQ1FromDC2020()
    {
        $projectId = self::DC2020_PROJECT_ID;
        $date = self::DATE_FROM_Q1_DC2020;

        $period_id = ProjectPeriod::getPeriodByDate($date, $projectId);

        $this->assertEquals(1, $period_id);

    }

    public function testIfDateIsFromQ2FromDC2020()
    {
        $projectId = self::DC2020_PROJECT_ID;
        $date = self::DATE_FROM_Q2_DC2020;

        $period_id = ProjectPeriod::getPeriodByDate($date, $projectId);

        $this->assertEquals(2, $period_id);

    }

    public function testIfDateIsFromQ3FromDC2020()
    {
        $projectId = self::DC2020_PROJECT_ID;
        $date = self::DATE_FROM_Q3_DC2020;

        $period_id = ProjectPeriod::getPeriodByDate($date, $projectId);

        $this->assertEquals(3, $period_id);

    }

    public function testWhenDateFromMovementIsOutFromCurrentPeriod()
    {
        $projectId = self::DC2020_PROJECT_ID;
        $date = self::DATE_FROM_Q1_DC2020;

        $checkDate = (new CheckIfDateIsOutPeriod(self::DATE_FROM_Q1_DC2020, self::DC2020_PROJECT_ID))
            ->setPeriodSuchDate()
            ->setPeriodSuchCurrentDate();

            $this->assertEquals(false, $checkDate->result());

    }
}