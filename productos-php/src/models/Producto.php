<?php

namespace models;

class Producto
{
    public static $IMAGEN_DEFAULT = 'https://via.placeholder.com/150';
    private $id;
    private $uuid;
    private $descripcion;
    private $imagen;
    private $marca;
    private $modelo;
    private $precio;
    private $stock;
    private $createdAt;
    private $updatedAt;
    private $categoriaId;
    private $categoriaNombre; // Para almacenar el nombre de la categoría
    private $isDeleted;

    // Constructor con parámetros opcionales
    public function __construct($id = null, $uuid = null, $descripcion = null, $imagen = null, $marca = null, $modelo = null, $precio = null, $stock = null, $createdAt = null, $updatedAt = null, $categoriaId = null, $categoriaNombre = null, $isDeleted = null)
    {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->descripcion = $descripcion;
        $this->imagen = $imagen ?? self::$IMAGEN_DEFAULT;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->categoriaId = $categoriaId;
        $this->categoriaNombre = $categoriaNombre;
        $this->isDeleted = $isDeleted;
    }

    // Magic method for get and set
    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
