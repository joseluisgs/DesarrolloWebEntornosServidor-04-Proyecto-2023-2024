<?php

namespace config;

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

class Config
{
    private static $instance = null;
    private $postgresDb;
    private $postgresUser;
    private $postgresPassword;
    private $postgresHost;
    private $postgresPort;

    private function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__, '../.env');
        $dotenv->load();

        // Cargar las variables de entorno y almacenarlas en las propiedades.
        $this->postgresDb = getenv('POSTGRES_DB');
        $this->postgresUser = getenv('POSTGRES_USER');
        $this->postgresPassword = getenv('POSTGRES_PASSWORD');
        $this->postgresHost = getenv('POSTGRES_HOST');
        $this->postgresPort = getenv('POSTGRES_PORT');
    }

    public static function getInstance(): Config
    {
        if (self::$instance === null) {
            self::$instance = new Config();
        }
        return self::$instance;
    }

    // Métodos públicos para acceder a las propiedades.
    public function getPostgresDb()
    {
        return $this->postgresDb;
    }

    public function getPostgresUser()
    {
        return $this->postgresUser;
    }

    public function getPostgresPassword()
    {
        return $this->postgresPassword;
    }

    public function getPostgresHost()
    {
        return $this->postgresHost;
    }

    public function getPostgresPort()
    {
        return $this->postgresPort;
    }
}