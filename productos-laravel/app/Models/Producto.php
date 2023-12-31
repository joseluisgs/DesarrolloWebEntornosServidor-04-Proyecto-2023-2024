<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Producto extends Model
{
    public static string $IMAGE_DEFAULT = 'https://via.placeholder.com/150';
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
        'categoria_id',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($producto) {
            $producto->uuid = Str::uuid();
        });
    }

    // Para solucionar el problema del uuid

    public function scopeSearch($query, $search)
    {
        return $query->whereRaw('LOWER(modelo) LIKE ?', ["%" . strtolower($search) . "%"])
            ->orWhereRaw('LOWER(marca) LIKE ?', ["%" . strtolower($search) . "%"]);
    }

    // Relación de producto con categoría:
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
