<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    /**
     * Estos se pueden asignar en masa con el método create() o update().
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'marca',
        'modelo',
        'descripcion',
        'imagen',
        'precio',
        'stock',
        'categoria',
        'isDeleted',
    ];

    /**
     * Esto se oculta cuando se serializa el modelo.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'isDeleted',
    ];

    /**
     * Esto se convierte automáticamente en tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'isDeleted' => 'boolean',
    ];

    // scope para el buscador de producto
    /*public function scopeSearch($query, $name)
    {
        // pasamos el nombre del producto y buscamos en la base de datos pero lo hacemos todo en minusculas
        return $query->where('modelo', 'LIKE', "%$name%")->orWhere('marca', 'LIKE', "%$name%");
    }*/

    public function scopeSearch($query, $name)
    {
        return $query->whereRaw('LOWER(modelo) LIKE ?', ["%" . strtolower($name) . "%"])
            ->orWhereRaw('LOWER(marca) LIKE ?', ["%" . strtolower($name) . "%"]);
    }
}
