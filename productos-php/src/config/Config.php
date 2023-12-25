<?php

namespace config;


use Dotenv\Dotenv;
use PDO;


class Config
{
    private static $instance;
    private $postgresDb;
    private $postgresUser;
    private $postgresPassword;
    private $postgresHost;
    private $postgresPort;
    private $db;

    private $rootPath = '/var/www/html/public/';

    private function __construct()
    {

        $dotenv = Dotenv::createImmutable($this->rootPath);
        $dotenv->load();

        // Cargar las variables de entorno y almacenarlas en las propiedades.
        $this->postgresDb = getenv('POSTGRES_DB') ?? 'default_db';
        $this->postgresUser = getenv('POSTGRES_USER') ?? 'default_user';
        $this->postgresPassword = getenv('POSTGRES_PASSWORD') ?? 'default_password';
        $this->postgresHost = getenv('POSTGRES_HOST') ?? 'localhost';
        $this->postgresPort = getenv('POSTGRES_PORT') ?? '5432';
        $this->db = new PDO("pgsql:host={$this->postgresHost};port={$this->postgresPort};dbname={$this->postgresDb}", $this->postgresUser, $this->postgresPassword);
    }

    public static function getInstance(): Config
    {
        if (!isset(self::$instance)) {
            self::$instance = new Config();
        }
        return self::$instance;
    }


    // Magic methos for get and set
    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

}