<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'Srpski jezik'],
            ['name' => 'Matematika'],
            ['name' => 'Fizika'],
            ['name' => 'Hemija'],
            ['name' => 'Informatika'],
            ['name' => 'Biologija'],
            ['name' => 'Istorija'],
            ['name' => 'Geografija'],
            ['name' => 'Engleski jezik'],
            ['name' => 'Njemački jezik'],
            ['name' => 'Latinski jezik'],
            ['name' => 'Psihologija'],
            ['name' => 'Sociologija'],
            ['name' => 'Logika'],
            ['name' => 'Filozofija'],
            ['name' => 'Demokratija'],
            ['name' => 'Pravoslavna vjeronauka'],
            ['name' => 'Muzička kultura'],
        ];

        DB::table('subjects')->insert($subjects);
    }
}
