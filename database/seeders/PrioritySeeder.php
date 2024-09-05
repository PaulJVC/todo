<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('priorities')->insert([
            ['name' => 'low', 'level' => 1],
            ['name' => 'normal', 'level' => 2],
            ['name' => 'high', 'level' => 3],
            ['name' => 'urgent', 'level' => 4],
        ]);
    }
}
