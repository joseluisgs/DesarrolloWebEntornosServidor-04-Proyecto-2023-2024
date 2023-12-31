<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    // Relación con la tabla productos

    public static function getIdPorNombre($nombre)
    {
        $categoria = self::where('nombre', $nombre)->first();
        return $categoria ? $categoria->id : null;
    }

    // Método para obtener el id de una categoría dado su nombre

    public static function getNombrePorId($id)
    {
        $categoria = self::find($id);
        return $categoria ? $categoria->nombre : null;
    }

    // Método para obtener el nombre de una categoría dado su id

    public static function getNombres()
    {
        return self::pluck('nombre');
    }

    // Método para obtener todos los nombres de las categorías

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

}
