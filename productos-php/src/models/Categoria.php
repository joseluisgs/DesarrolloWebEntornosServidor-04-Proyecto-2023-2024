<?php

namespace models;

use Ramsey\Uuid\Uuid;

class Categoria
{
    private $id;
    private $nombre;
    private $createdAt;
    private $updatedAt;
    private $isDeleted;

    public function __construct($id = null, $nombre = null, $createdAt = null, $updatedAt = null, $isDeleted = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->isDeleted = $isDeleted;
    }

    public function getId()
    {
        return $this->id;
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

    private function generateUUID()
    {
        return Uuid::uuid4()->toString();
    }
}

?>