<?php

class ControladorUsuarios
{
    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Creamos la conexión utilizando la clase que hemos creado
            $connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
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

                    //Redirigimos a inicio
                    header('location: index.php?accion=inicio');
                    die();
                }
            }

            //email o password incorrectos
            guardarMensaje("Email o password incorrectos");

        } //Acaba if($_SERVER['REQUEST_METHOD']=='POST'){...}

        require 'app/vistas/login.php';
    }

    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Limpiamos los datos
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);

            //Validación 

            //Conectamos con la BD
            $connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            //Compruebo que no haya un usuario registrado con el mismo email
            $usuariosDAO = new UsuariosDAO($conn);
            if ($usuariosDAO->getByEmail($email) != null) {
                guardarMensaje("Ya existe un usuario con ese email");
            } else {
                //Insertamos en la BD

                $usuario = new Usuario();
                $usuario->setEmail($email);

                //encriptamos el password
                $passwordCifrado = password_hash($password, PASSWORD_DEFAULT);
                $usuario->setPassword($passwordCifrado);

                if ($usuariosDAO->insert($usuario)) {
                    header("location: index.php?accion=inicio");
                    die();
                } else {
                    guardarMensaje("No se ha podido insertar el usuario");
                }
            }
        }   //Acaba if($_SERVER['REQUEST_METHOD']=='POST'){...}

        require 'app/vistas/registro.php';
    }

    public function logout()
    {
        Sesion::cerrarSesion();
        setcookie('id', '', 0, '/');
        header('location: index.php');
    }
}
