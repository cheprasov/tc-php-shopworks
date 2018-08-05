<?php

namespace Tests\Feature\Service\ManningCalculator;

use App\Model\Shop\Rota\Rota;
use App\Service\ManningCalculator\DTO\SingleManning;
use App\Service\ManningCalculator\ManningCalculator;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ManningCalculatorTest extends TestCase
{
    public static $isDatabaseReady = false;

    public function setUp()
    {
        parent::setUp();
        if (!self::$isDatabaseReady) {
            $this->setupDatabase();
        }
    }

    public function setupDatabase()
    {
        Artisan::call('migrate');
        Artisan::call('db:seed', ['--class' => \TestDataSeeder::class]);
        self::$isDatabaseReady = true;
    }

    /**
     * @return SingleManning
     */
    protected function getSimpleManning($rotaId): SingleManning
    {
        $Rota = Rota::find($rotaId);
        $this->assertTrue($Rota instanceof Rota);

        $ManningCalculator = new ManningCalculator();
        $SimpleManning = $ManningCalculator->getSimpleManning($Rota);
        return $SimpleManning;
    }

    /**
     * @see \TestDataSeeder
     */
    public function testScenarioOne()
    {
        // Black Widow: |----------------------|
        $this->assertSame([1 => 480,], $this->getSimpleManning(1)->getMinutesByDate('2018-02-01'));
    }

    /**
     * @see \TestDataSeeder
     */
    public function testScenarioTwo()
    {
        // Black Widow: |----------|
        // Thor:                   |-------------|
        $this->assertSame([1 => 180, 2 => 300], $this->getSimpleManning(1)->getMinutesByDate('2018-02-02'));
    }

    /**
     * @see \TestDataSeeder
     */
    public function testScenarioThree()
    {
        // Wolverine: |------------|
        // Gamora:       |-----------------|
        $this->assertSame([3 => 60, 4 => 120], $this->getSimpleManning(1)->getMinutesByDate('2018-02-03'));
    }

    /**
     * @see \TestDataSeeder
     */
    public function testScenarioFour()
    {
        // Wolverine: |----|    |-----------------|
        // Gamora:    |----------------|    |-----|
        $this->assertSame([3 => 50, 4 => 60], $this->getSimpleManning(1)->getMinutesByDate('2018-02-04'));
    }

    /**
     * @see \TestDataSeeder
     */
    public function testScenarioFive()
    {
        // Black Widow: |----|    |------|    |----|
        // Thor:           |-------|   |-------|
        $this->assertSame([1 => 260, 2 => 240], $this->getSimpleManning(1)->getMinutesByDate('2018-02-05'));
    }

    /**
     * @see \TestDataSeeder
     */
    public function testScenarioSix()
    {
        // Black Widow: |-----------------|
        // Thor:        |-------|     |-------|
        // Wolverine:      |------|      |-------|
        $this->assertSame([1 => 40, 3 => 120], $this->getSimpleManning(1)->getMinutesByDate('2018-02-06'));
    }

    /**
     * @see \TestDataSeeder
     */
    public function testScenarioSeven()
    {
        // Black Widow: |--|    |--|
        // Thor:           |--|    |--|
        // Wolverine:         |--|    |--|
        // Gamora:         |----------|
        $this->assertSame([1 => 120, 3 => 130], $this->getSimpleManning(1)->getMinutesByDate('2018-02-07'));
    }

    /**
     * @see \TestDataSeeder
     */
    public function testScenarioEight()
    {
        // Black Widow: |-------------|
        // Thor:        |-------------|
        // Wolverine:   |-------------|
        // Gamora:      |-------------|
        $this->assertSame([], $this->getSimpleManning(2)->getMinutesByDate('2018-02-08'));
    }

    public function testScenarioEmpty()
    {
        $this->assertSame([], $this->getSimpleManning(1)->getMinutesByDate('2018-02-09'));
        $this->assertSame([], $this->getSimpleManning(2)->getMinutesByDate('2018-02-09'));
    }
}
