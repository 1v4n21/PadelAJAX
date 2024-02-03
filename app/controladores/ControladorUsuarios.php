<?php

class ControladorUsuarios
{
    public function inicio()
    {
        //Incluyo la vista
        require 'app/vistas/login.php';
    }

    public function login()
    {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConexionDB();
        $conn = $connexionDB->getConnexion();

        //limpiamos los datos que vienen del usuario
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        //Validamos el usuario
        $usuariosDAO = new UsuariosDAO($conn);
        if ($usuario = $usuariosDAO->getByEmail($email)) {
            if (password_verify($password, $usuario->getPassword())) {
                //email y password correctos. Inciamos sesión
                Sesion::iniciarSesion($usuario);

                //Creamos la cookie para que nos recuerde 1 semana
                setcookie('id', $usuario->getid(), time() + 24 * 60 * 60, '/');

                //Redirigimos a index.php
                header('location: index.php');
                die();
            }
        }
        //email o password incorrectos, redirigir a index.php
        guardarMensaje("Email o password incorrectos");
        header('location: index.php');
    }

    public function logout()
    {
        Sesion::cerrarSesion();
        setcookie('id', '', 0, '/');
        header('location: index.php');
    }
}
