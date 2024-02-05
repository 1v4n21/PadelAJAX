<?php

class Sesion
{
    static public function getUsuario(): Usuario|false
    {
        if (isset($_SESSION['usuario'])) {
            return unserialize($_SESSION['usuario']);
        } else {
            return false;
        }
    }

    static public function iniciarSesion($usuario)
    {
        $_SESSION['usuario'] = serialize($usuario);
        self::crearCookie($usuario->getId());
    }

    static public function cerrarSesion()
    {
        unset($_SESSION['usuario']);
        self::eliminarCookie();
    }

    private static function crearCookie($id)
    {
        setcookie('sid', $id, time() + 7 * 60 * 60 * 24, '/');
    }

    private static function eliminarCookie()
    {
        setcookie('sid', '', 0, '/');
    }

    static public function existeSesion()
    {
        if (isset($_SESSION['usuario'])) {
            return true;
        } else {
            return false;
        }
    }
}
/**
 * Para iniciar sesión: Sesion::iniciarSesion($usuario);
 * Para cerrar sesión: Sesion::cerrarSesion();
 * Para obtener el usuario: Sesion::getUsuario()
 * Para obener una propiedad del usuario: Sesion::getUsuario()->getFoto()
 * Para comprobar si se ha iniciado sesión: existeSesion()...
 */
