<?php
namespace models;

use app\modules\project\components\ArraySum;
use Codeception\Test\Unit;
use UnitTester;

class ArraySumTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;
    

    public function testSumIsFloat()
    {
        $values =  [200, 90000, 233.33];
        $result = ArraySum::make($values);
        $this->assertIsFloat($result);
    }

    public function testSumIsCorrectWhenNumberIsPositive()
    {
        $values =  [200, 90000, 233.33];
        $result = ArraySum::make($values);
        $this->assertEquals(90433.33, $result);
    }

    public function testSumIsCorrectWhenSomeNumberIsNegative()
    {
        $values =  [-10, 90000, 233.33];
        $result = ArraySum::make($values);
        $this->assertEquals(90223.33, $result);
    }

    public function testSumIsCorrectWhenSomeValueNoIsNumber()
    {
        $values =  [200, 90000, 'No lo se Rick'];
        $result = ArraySum::make($values);
        $this->assertEquals(90200, $result);
    }
}