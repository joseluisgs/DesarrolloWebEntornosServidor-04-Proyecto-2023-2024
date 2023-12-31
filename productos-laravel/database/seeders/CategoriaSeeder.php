<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['nombre' => 'DEPORTES'],
            ['nombre' => 'COMIDA'],
            ['nombre' => 'BEBIDA'],
            ['nombre' => 'COMPLEMENTOS'],
            ['nombre' => 'OTROS']
        ]);
    }
}
