<?php
namespace models;

use app\modules\project\components\CompareDates;
use Codeception\Test\Unit;
use UnitTester;

class CheckDatesTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    public function testCompareIfStarDateIsGreaterWithFormatYearMonthDay()
    {
        $start = '2021-07-16';
        $end = '2021-07-15';

        $checkDates = (new CompareDates($start, $end))->parseToDate();

        $this->assertEquals(true, $checkDates->isStartGreaterThanEnd());
    }

    public function testCompareIfStarDateIsLessWithFormatYearMonthDay()
    {
        $start = '2021-07-01';
        $end = '2021-08-15';

        $checkDates = (new CompareDates($start, $end))->parseToDate();

        $this->assertEquals(false, $checkDates->isStartGreaterThanEnd());
    }

    public function testCompareIfStarDateIsGreaterWithFormatDayMonthYearWithSlashes()
    {
        $start = '17/03/2021';
        $end = '13/03/2021';

        $checkDates = (new CompareDates($start, $end, 'd/m/Y'))->changeFormat()->parseToDate();

        $this->assertEquals(true, $checkDates->isStartGreaterThanEnd());
    }

    public function testCompareIfStarDateIsLessWithFormatDayMonthYearWithSlashes()
    {
        $start = '12/03/2021';
        $end = '13/03/2021';

        $checkDates = (new CompareDates($start, $end, 'd/m/Y'))->changeFormat()->parseToDate();

        $this->assertEquals(false, $checkDates->isStartGreaterThanEnd());
    }

    public function testCompareIfStarDateIsEqualWithFormatDayMonthYearWithSlashes()
    {
        $start = '24/03/2021';
        $end = '24/03/2021';

        $checkDates = (new CompareDates($start, $end, 'd/m/Y'))->changeFormat()->parseToDate();

        $this->assertEquals(true, $checkDates->areDateEquals());
    }

    public function testCompareIfStarDateIsEqualWithFormatYearMonthDate()
    {
        $start = '2019-03-01';
        $end = '2019-03-01';

        $checkDates = (new CompareDates($start, $end, 'Y-m-d'))->changeFormat()->parseToDate();

        $this->assertEquals(true, $checkDates->areDateEquals());
    }
}