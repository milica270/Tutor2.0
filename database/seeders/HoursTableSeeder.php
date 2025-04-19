<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HoursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hours')->insert([
            ['id' => 1, 'begin_time' => '07:30', 'end_time' => '08:15'],
            ['id' => 2, 'begin_time' => '08:20', 'end_time' => '09:05'],
            ['id' => 3, 'begin_time' => '09:10', 'end_time' => '09:55'],
            ['id' => 4, 'begin_time' => '10:10', 'end_time' => '10:55'],
            ['id' => 5, 'begin_time' => '11:00', 'end_time' => '11:45'],
            ['id' => 6, 'begin_time' => '11:50', 'end_time' => '12:35'],
            ['id' => 7, 'begin_time' => '12:40', 'end_time' => '13:25'],
            ['id' => 8, 'begin_time' => '13:30', 'end_time' => '14:15'],
        ]);
    }
}
