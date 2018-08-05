<?php

namespace Tests\Unit\Service\ManningCalculator;

use App\Model\Shop\Rota\Rota;
use App\Model\Shop\Rota\Shift;
use App\Service\ManningCalculator\ManningCalculator;
use App\Service\Period\PeriodFactory;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

/**
 * @see \App\Service\ManningCalculator\ManningCalculator
 */
class ManningCalculatorTest extends TestCase
{

    /**
     * @see \App\Service\ManningCalculator\ManningCalculator::getSimpleManning
     */
    public function testGetSimpleMannings()
    {
        /** @var MockObject|Rota $RotaMock */
        $RotaMock = $this->getMockBuilder(Rota::class)
            ->disableOriginalConstructor()
            ->setMethods(['shiftsByDate'])
            ->getMock();

        $RotaMock->week_commence_date = '2018-01-10';

        $RotaMock->expects($this->once())
            ->method('shiftsByDate')
            ->willReturn(
                [
                    '2018-01-10' => [1 => 120, 2 => 200, 3 => 60],
                    '2018-01-11' => [1 => 240],
                    '2018-01-13' => [2 => 400],
                    '2018-01-15' => [3 => 200, 42 => 420],
                ]
            );

        /** @var MockObject|ManningCalculator $ManningCalculatorMock */
        $ManningCalculatorMock = $this->getMockBuilder(ManningCalculator::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStaffSingleMinutesByShift'])
            ->getMock();

        $ManningCalculatorMock->expects($this->exactly(4))
            ->method('getStaffSingleMinutesByShift')
            ->willReturnArgument(0);

        $SimpleMannings = $ManningCalculatorMock->getSimpleManning($RotaMock);
        $this->assertSame(
            [
                '2018-01-10' => [1 => 120, 2 => 200, 3 => 60],
                '2018-01-11' => [1 => 240],
                '2018-01-12' => [],
                '2018-01-13' => [2 => 400],
                '2018-01-14' => [],
                '2018-01-15' => [3 => 200, 42 => 420],
                '2018-01-16' => [],
            ],
            $SimpleMannings->getStaffMinutesByDate()
        );
    }

    /**
     * @see \App\Service\ManningCalculator\ManningCalculator::getStaffSingleMinutesByShift
     */
    public function testGetStaffSingleMinutesByShift()
    {
        $periods = [
            1 => ['2018-01-10 10:00:00', '2018-01-10 11:00:00'], // 30 min
            2 => ['2018-01-10 10:30:00', '2018-01-10 11:00:00'], //  0 min
            3 => ['2018-01-10 12:00:00', '2018-01-10 14:00:00'], // 60 min
            4 => ['2018-01-10 13:00:00', '2018-01-10 15:00:00'], // 50 min
            5 => ['2018-01-10 14:50:00', '2018-01-10 15:20:00'], // 20 min
        ];

        $shifts = [];
        for ($i = 1; $i <= 5; $i++) {
            $ShiftMock = $this->getMockBuilder(Shift::class)
                ->disableOriginalConstructor()
                ->setMethods(['getWorkPeriods'])
                ->getMock();

            $ShiftMock->staff_id = $i;

            $PeriodCollection = PeriodFactory::createCollection();
            $PeriodCollection->addPeriods(PeriodFactory::createPeriod($periods[$i][0], $periods[$i][1]));

            $ShiftMock->expects($this->any())
                ->method('getWorkPeriods')
                ->willReturn($PeriodCollection);

            $shifts[] = $ShiftMock;
        }

        $ManningCalculatorMock = new ManningCalculator();
        $Method = new \ReflectionMethod(ManningCalculator::class, 'getStaffSingleMinutesByShift');
        $Method->setAccessible(true);

        $result = $Method->invoke($ManningCalculatorMock, $shifts);
        $this->assertSame([1 => 30, 3 => 60, 4 => 50, 5 => 20], $result);
    }
}
