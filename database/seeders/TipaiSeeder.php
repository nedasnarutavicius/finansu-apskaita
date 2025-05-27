<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipai')->insert([
            ['pavadinimas' => 'Pajamos'],
            ['pavadinimas' => 'Išlaidos'],
        ]);
    }
}
