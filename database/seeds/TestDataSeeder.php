<?php

use App\Model\Shop\Rota\Rota;
use App\Model\Shop\Rota\Shift;
use App\Model\Shop\Rota\ShiftBreak;
use App\Model\Shop\Shop;
use App\Model\Shop\Staff;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Shop::truncate();
        Shop::create(['id' => 1, 'name' => 'FunHouse']);

        Staff::truncate();
        Staff::create(['id' => 1, 'first_name' => 'Black Widow', 'surname' => 'Hero', 'shop_id' => 1]);
        Staff::create(['id' => 2, 'first_name' => 'Thor', 'surname' => 'Hero', 'shop_id' => 1]);
        Staff::create(['id' => 3, 'first_name' => 'Wolverine', 'surname' => 'Hero', 'shop_id' => 1]);
        Staff::create(['id' => 4, 'first_name' => 'Gamora', 'surname' => 'Hero', 'shop_id' => 1]);

        Rota::truncate();
        Rota::create(['id' => 1, 'shop_id' => 1, 'week_commence_date' => '2018-02-01']);
        Rota::create(['id' => 2, 'shop_id' => 1, 'week_commence_date' => '2018-02-08']);

        Shift::truncate();
        ShiftBreak::truncate();

        // Scenario One
        // Black Widow: |----------------------|
        Shift::create(
            [
                'id' => 1,
                'rota_id' => 1,
                'staff_id' => 1,
                'start_time' => '2018-02-01 10:00:00',
                'end_time' => '2018-02-01 18:00:00'
            ]
        );

        // Scenario Two
        // Black Widow: |----------|
        // Thor:                   |-------------|
        Shift::create(
            [
                'id' => 2,
                'rota_id' => 1,
                'staff_id' => 1,
                'start_time' => '2018-02-02 10:00:00',
                'end_time' => '2018-02-02 13:00:00'
            ]
        );
        Shift::create(
            [
                'id' => 3,
                'rota_id' => 1,
                'staff_id' => 2,
                'start_time' => '2018-02-02 13:00:00',
                'end_time' => '2018-02-02 18:00:00'
            ]
        );

        // Scenario Three
        // Wolverine: |------------|
        // Gamora:       |-----------------|
        Shift::create(
            [
                'id' => 4,
                'rota_id' => 1,
                'staff_id' => 3,
                'start_time' => '2018-02-03 10:00:00',
                'end_time' => '2018-02-03 16:00:00'
            ]
        );
        Shift::create(
            [
                'id' => 5,
                'rota_id' => 1,
                'staff_id' => 4,
                'start_time' => '2018-02-03 11:00:00',
                'end_time' => '2018-02-03 18:00:00'
            ]
        );

        // Scenario Four
        // Wolverine: |----|    |-----------------|
        // Gamora:    |----------------|    |-----|

        Shift::create(
            [
                'id' => 6,
                'rota_id' => 1,
                'staff_id' => 3,
                'start_time' => '2018-02-04 10:00:00',
                'end_time' => '2018-02-04 18:00:00'
            ]
        );
        ShiftBreak::create(['shift_id' => 6, 'start_time' => '2018-02-04 12:00:00', 'end_time' => '2018-02-04 13:00:00']);

        Shift::create(
            [
                'id' => 7,
                'rota_id' => 1,
                'staff_id' => 4,
                'start_time' => '2018-02-04 10:00:00',
                'end_time' => '2018-02-04 18:00:00'
            ]
        );
        ShiftBreak::create(['shift_id' => 7, 'start_time' => '2018-02-04 16:10:00', 'end_time' => '2018-02-04 17:00:00']);

        // Scenario Five
        // Black Widow: |----|    |------|    |----|
        // Thor:           |-------|   |-------|

        Shift::create(
            [
                'id' => 8,
                'rota_id' => 1,
                'staff_id' => 1,
                'start_time' => '2018-02-05 10:00:00',
                'end_time' => '2018-02-05 20:00:00'
            ]
        );
        ShiftBreak::create(['shift_id' => 8, 'start_time' => '2018-02-05 12:00:00', 'end_time' => '2018-02-05 14:00:00']);
        ShiftBreak::create(['shift_id' => 8, 'start_time' => '2018-02-05 16:00:00', 'end_time' => '2018-02-05 18:00:00']);

        Shift::create(
            [
                'id' => 9,
                'rota_id' => 1,
                'staff_id' => 2,
                'start_time' => '2018-02-05 11:30:00',
                'end_time' => '2018-02-05 18:30:00'
            ]
        );
        ShiftBreak::create(['shift_id' => 9, 'start_time' => '2018-02-05 14:20:00', 'end_time' => '2018-02-05 15:40:00']);

        // Scenario Six
        // Black Widow: |-----------------|
        // Thor:        |-------|     |-------|
        // Wolverine:      |------|      |-------|

        Shift::create(
            [
                'id' => 10,
                'rota_id' => 1,
                'staff_id' => 1,
                'start_time' => '2018-02-06 10:00:00',
                'end_time' => '2018-02-06 18:00:00'
            ]
        );

        Shift::create(
            [
                'id' => 11,
                'rota_id' => 1,
                'staff_id' => 2,
                'start_time' => '2018-02-06 10:00:00',
                'end_time' => '2018-02-06 20:00:00'
            ]
        );
        ShiftBreak::create(['shift_id' => 11, 'start_time' => '2018-02-06 14:00:00', 'end_time' => '2018-02-06 15:00:00']);

        Shift::create(
            [
                'id' => 12,
                'rota_id' => 1,
                'staff_id' => 3,
                'start_time' => '2018-02-06 12:00:00',
                'end_time' => '2018-02-06 22:00:00'
            ]
        );
        ShiftBreak::create(['shift_id' => 12, 'start_time' => '2018-02-06 14:20:00', 'end_time' => '2018-02-06 15:20:00']);

        // Scenario Seven
        // Black Widow: |--|    |--|
        // Thor:           |--|    |--|
        // Wolverine:         |--|    |--|
        // Gamora:         |----------|

        Shift::create(
            [
                'id' => 13,
                'rota_id' => 1,
                'staff_id' => 1,
                'start_time' => '2018-02-07 10:00:00',
                'end_time' => '2018-02-07 18:00:00'
            ]
        );
        ShiftBreak::create(['shift_id' => 13, 'start_time' => '2018-02-06 12:00:00', 'end_time' => '2018-02-06 16:00:00']);

        Shift::create(
            [
                'id' => 14,
                'rota_id' => 1,
                'staff_id' => 2,
                'start_time' => '2018-02-07 12:00:00',
                'end_time' => '2018-02-07 20:00:00'
            ]
        );
        ShiftBreak::create(['shift_id' => 14, 'start_time' => '2018-02-06 14:00:00', 'end_time' => '2018-02-06 18:00:00']);

        Shift::create(
            [
                'id' => 15,
                'rota_id' => 1,
                'staff_id' => 3,
                'start_time' => '2018-02-07 14:00:00',
                'end_time' => '2018-02-07 22:10:00'
            ]
        );
        ShiftBreak::create(['shift_id' => 15, 'start_time' => '2018-02-06 16:00:00', 'end_time' => '2018-02-06 20:00:00']);

        Shift::create(
            [
                'id' => 16,
                'rota_id' => 1,
                'staff_id' => 4,
                'start_time' => '2018-02-07 12:00:00',
                'end_time' => '2018-02-07 20:00:00'
            ]
        );

        // Scenario Eight
        // Black Widow: |-------------|
        // Thor:        |-------------|
        // Wolverine:   |-------------|
        // Gamora:      |-------------|

        Shift::create(
            [
                'id' => 17,
                'rota_id' => 2,
                'staff_id' => 1,
                'start_time' => '2018-02-07 10:00:00',
                'end_time' => '2018-02-07 18:00:00'
            ]
        );

        Shift::create(
            [
                'id' => 18,
                'rota_id' => 2,
                'staff_id' => 2,
                'start_time' => '2018-02-07 10:00:00',
                'end_time' => '2018-02-07 18:00:00'
            ]
        );

        Shift::create(
            [
                'id' => 19,
                'rota_id' => 2,
                'staff_id' => 3,
                'start_time' => '2018-02-07 10:00:00',
                'end_time' => '2018-02-07 18:00:00'
            ]
        );

        Shift::create(
            [
                'id' => 20,
                'rota_id' => 2,
                'staff_id' => 4,
                'start_time' => '2018-02-07 10:00:00',
                'end_time' => '2018-02-07 18:00:00'
            ]
        );

    }
}
