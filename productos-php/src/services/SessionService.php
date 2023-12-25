<?php

namespace services;

/**
 * Class SessionService
 * @package services
 * Esta clase se encarga de gestionar la sesión de usuario
 */
class SessionService
{

    private static $instance;
    private $expireAfterSeconds = 3600; // Una hora en segundos

    private function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->checkSessionValidity();
        $this->initSession();
    }

    private function checkSessionValidity()
    {
        if (isset($_SESSION['last_activity'])) {
            $secondsInactive = time() - $_SESSION['last_activity'];
            if ($secondsInactive >= $this->expireAfterSeconds) {
                $this->clear(); // Limpia y destruye la sesión
                // Podrías añadir una redirección aquí o manejar la expiración de la sesión como prefieras
            }
        }
    }

    public function clear()
    {
        session_unset();
        session_destroy();
    }

    private function initSession()
    {
        if (!isset($_SESSION['visits'])) {
            $_SESSION['visits'] = 0;
        }

        if (!isset($_SESSION['loggedIn'])) {
            $_SESSION['loggedIn'] = false;
        }

        if (!isset($_SESSION['isAdmin'])) {
            $_SESSION['isAdmin'] = false;
        }

        if (!isset($_SESSION['username'])) {
            $_SESSION['username'] = null;
        }

        if (!isset($_SESSION['lastLoginDate'])) {
            $_SESSION['lastLoginDate'] = null;
        }

        if (isset($_SESSION['visits']) && $_SESSION['loggedIn']) {
            $_SESSION['visits']++;
        }

        // Establecer la marca de tiempo de la última actividad
        $this->refreshLastActivity(); // Actualizar la última actividad al iniciar la sesión

    }

    public function refreshLastActivity()
    {
        $_SESSION['last_activity'] = time();
    }

    public static function getInstance(): SessionService
    {
        if (!isset(self::$instance)) {
            self::$instance = new SessionService();
        }
        return self::$instance;
    }

    public function isLoggedIn()
    {
        return $_SESSION['loggedIn'];
    }

    public function isAdmin()
    {
        return $_SESSION['isAdmin'];
    }

    public function getVisitCount()
    {
        return $_SESSION['visits'];
    }

    public function login($username, $isAdmin)
    {
        $_SESSION['loggedIn'] = true;
        $_SESSION['isAdmin'] = $isAdmin;
        $_SESSION['username'] = $username;
        $_SESSION['lastLoginDate'] = date('Y-m-d H:i:s');
        $this->refreshLastActivity(); // Actualizar la última actividad en el login
    }

    public function logout()
    {
        $_SESSION['loggedIn'] = false;
        $_SESSION['isAdmin'] = false;
        $_SESSION['username'] = null;
        $_SESSION['visits'] = 0;
        $_SESSION['lastLoginDate'] = null;
    }

    public function getWelcomeMessage()
    {
        return "Listado de Productos";
    }

    public function getUsername()
    {
        return $_SESSION['username'];
    }

    public function getLastLoginDate()
    {
        return $_SESSION['lastLoginDate'];
    }

}