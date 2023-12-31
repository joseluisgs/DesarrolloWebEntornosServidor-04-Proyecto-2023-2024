<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    // Relación con la tabla productos
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
