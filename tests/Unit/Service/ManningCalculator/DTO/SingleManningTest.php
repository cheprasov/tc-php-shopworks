<?php

namespace Tests\Unit\Service\ManningCalculator\DTO;

use App\Service\ManningCalculator\DTO\SingleManning;
use Tests\TestCase;

/**
 * @see \App\Service\ManningCalculator\DTO\SingleManning
 */
class SingleManningTest extends TestCase
{
    public function providerTestSetStaffMinutesByDate()
    {
        return [
            'line_' . __LINE__ => [
                'date' => '2018-01-01',
                'staffMinutesByDate' => [],
                'expect' => [
                    '2018-01-01' => [],
                    '2018-01-02' => [],
                    '2018-01-03' => [],
                    '2018-01-04' => [],
                    '2018-01-05' => [],
                    '2018-01-06' => [],
                    '2018-01-07' => [],
                ],
            ],
            'line_' . __LINE__ => [
                'date' => '2018-01-31',
                'staffMinutesByDate' => [
                    '2018-02-02' => [1 => 120],
                    '2018-02-04' => [1 => 120, 42 => 120],
                    '2018-02-14' => [42 => 420],
                ],
                'expect' => [
                    '2018-01-31' => [],
                    '2018-02-01' => [],
                    '2018-02-02' => [1 => 120],
                    '2018-02-03' => [],
                    '2018-02-04' => [1 => 120, 42 => 120],
                    '2018-02-05' => [],
                    '2018-02-06' => [],
                ],
            ],
        ];
    }

    /**
     * @see \App\Service\ManningCalculator\DTO\SingleManning::setStaffMinutesByDate
     * @dataProvider providerTestSetStaffMinutesByDate
     */
    public function testSetStaffMinutesByDate($date, $staffMinutesByDate, $expect)
    {
        $SingleManning = new SingleManning(new \DateTime($date), $staffMinutesByDate);
        $this->assertSame($expect, $SingleManning->getStaffMinutesByDate());
    }

    /**
     * @see \App\Service\ManningCalculator\DTO\SingleManning::getWeekMinutesByStaffId
     */
    public function testGetWeekMinutesByStaffId()
    {
        $SingleManning = new SingleManning(
            new \DateTime('2018-05-01'),
            [
                '2018-05-01' => [1 => 60, 2 => 160, 3 => 240],
                '2018-05-02' => [1 => 160, 2 => 60],
                '2018-05-04' => [1 => 300, 3 => 400],
                '2018-05-05' => [42 => 420],
            ]
        );
        $this->assertSame(
            ['2018-05-01' => 60, '2018-05-02' => 160, '2018-05-04' => 300,],
            $SingleManning->getWeekMinutesByStaffId(1)
        );
        $this->assertSame(
            ['2018-05-01' => 160, '2018-05-02' => 60],
            $SingleManning->getWeekMinutesByStaffId(2)
        );
        $this->assertSame(
            ['2018-05-01' => 240, '2018-05-04' => 400],
            $SingleManning->getWeekMinutesByStaffId(3)
        );
        $this->assertSame(
            ['2018-05-05' => 420],
            $SingleManning->getWeekMinutesByStaffId(42)
        );
    }

    /**
     * @see \App\Service\ManningCalculator\DTO\SingleManning::getMinutesByDate
     */
    public function testGetMinutesByDate()
    {
        $SingleManning = new SingleManning(
            new \DateTime('2018-05-01'),
            [
                '2018-05-01' => [1 => 60, 2 => 160, 3 => 240],
                '2018-05-02' => [1 => 160, 2 => 60],
                '2018-05-04' => [1 => 300, 3 => 400],
                '2018-05-05' => [42 => 420],
            ]
        );
        $this->assertSame([], $SingleManning->getMinutesByDate('2018-04-01'));
        $this->assertSame([1 => 60, 2 => 160, 3 => 240], $SingleManning->getMinutesByDate('2018-05-01'));
        $this->assertSame([1 => 160, 2 => 60], $SingleManning->getMinutesByDate('2018-05-02'));
        $this->assertSame([], $SingleManning->getMinutesByDate('2018-05-03'));
        $this->assertSame([1 => 300, 3 => 400], $SingleManning->getMinutesByDate('2018-05-04'));
        $this->assertSame([42 => 420], $SingleManning->getMinutesByDate('2018-05-05'));
        $this->assertSame([], $SingleManning->getMinutesByDate('2018-05-10'));
    }
}
