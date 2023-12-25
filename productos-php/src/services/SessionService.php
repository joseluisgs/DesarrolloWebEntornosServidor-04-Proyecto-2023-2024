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

    private function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->initSession();
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

        if ($_SESSION['loggedIn']) {
            $_SESSION['visits']++;
        }
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
        $_SESSION['visits'] = 0;
    }

    public function logout()
    {
        $_SESSION['loggedIn'] = false;
        $_SESSION['isAdmin'] = false;
        $_SESSION['username'] = null;
        $_SESSION['visits'] = 0;
    }

    public function getWelcomeMessage()
    {
        return "Listado de Productos";
    }

    public function getUsername()
    {
        return $_SESSION['username'];
    }

    public function clear()
    {
        session_unset();
        session_destroy();
    }
}