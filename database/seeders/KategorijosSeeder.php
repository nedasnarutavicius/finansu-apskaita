<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategorijosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategorijos')->insert([
            ['pavadinimas' => 'Maistas'],
            ['pavadinimas' => 'Kuras'],
            ['pavadinimas' => 'Rūkymas'],
            ['pavadinimas' => 'Kelionės'],
            ['pavadinimas' => 'Būstas'],
            ['pavadinimas' => 'Sveikata'],
            ['pavadinimas' => 'Pramogos'],
            ['pavadinimas' => 'Kita'],
        ]);
    }
}
