<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('productos')->insert([
            [
                'uuid' => Str::uuid(),
                'marca' => 'Nike',
                'modelo' => 'Modelo 1',
                'descripcion' => 'Descripción 1',
                'precio' => 10.99,
                'stock' => 5,
                'categoria_id' => 1,
            ],
            [
                'uuid' => Str::uuid(),
                'marca' => 'Adidas',
                'modelo' => 'Modelo 2',
                'descripcion' => 'Descripción 2',
                'precio' => 20.99,
                'stock' => 10,
                'categoria_id' => 2,
            ],
            [
                'uuid' => Str::uuid(),
                'marca' => 'Nike',
                'modelo' => 'Modelo 3',
                'descripcion' => 'Descripción 3',
                'precio' => 30.99,
                'stock' => 15,
                'categoria_id' => 3,
            ],
            [
                'uuid' => Str::uuid(),
                'marca' => 'Adidas',
                'modelo' => 'Modelo 4',
                'descripcion' => 'Descripción 4',
                'precio' => 40.99,
                'stock' => 20,
                'categoria_id' => 3,
            ],
            [
                'uuid' => Str::uuid(),
                'marca' => 'Babolat',
                'modelo' => 'Modelo 5',
                'descripcion' => 'Descripción 5',
                'precio' => 50.99,
                'stock' => 25,
                'categoria_id' => 1,
            ],
        ]);
    }
}
