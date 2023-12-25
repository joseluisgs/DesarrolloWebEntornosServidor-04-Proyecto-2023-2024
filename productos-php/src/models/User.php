<?php

namespace models;

class User
{
    public $id;
    public $username;
    public $password;
    public $nombre;
    public $apellidos;
    public $email;
    public $createdAt;
    public $updatedAt;
    public $isDeleted;
    public $roles = []; // Array para almacenar los roles asociados al usuario

    // Constructor para inicializar el objeto User con los valores
    public function __construct($id, $username, $password, $nombre, $apellidos, $email, $createdAt, $updatedAt, $isDeleted, $roles = [])
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->isDeleted = $isDeleted;
        $this->roles = $roles;
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
