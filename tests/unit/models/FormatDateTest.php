<?php
namespace unit\models;

use app\modules\project\components\FormatDate;
use Codeception\Test\Unit;
use UnitTester;

class FormatDateTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;
    

    public function testChangeFormatYMDToDMY()
    {
        $date = '2020-01-01';
        $formatDate = (new FormatDate($date, 'Y-m-d', 'd/m/Y'))->change();
        $this->assertEquals('01/01/2020', $formatDate->asString());
    }

    public function testChangeFormatMDYToYMD()
    {
        $date = '26/11/2021';
        $formatDate = (new FormatDate($date, 'd/m/Y', 'Y-m-d'))->change();
        $this->assertEquals('2021-11-26', $formatDate->asString());
    }
}