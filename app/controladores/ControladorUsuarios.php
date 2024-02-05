<?php

class ControladorUsuarios
{
    public function login()
    {

        if (Sesion::existeSesion()) {
            // Si ya ha iniciado sesión, redirige a la página de inicio
            header('location: index.php?accion=inicio');
            guardarMensaje("No puedes acceder aqui si ya has iniciado sesion");
            die();
        }

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

                    //Redirigimos a inicio
                    header('location: index.php');
                    guardarMensajeC("Inicio de sesión con éxito");
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

        if (Sesion::existeSesion()) {
            // Si ya ha iniciado sesión, redirige a la página de inicio
            header('location: index.php?accion=inicio');
            guardarMensaje("No puedes acceder aqui si ya has iniciado sesion");
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Limpiamos los datos
            $nombre = htmlentities($_POST['nombre']);
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);
            $password2 = htmlentities($_POST['password2']);

            // Validación de correo electrónico
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                guardarMensaje("El formato del correo electrónico no es válido");
                require 'app/vistas/registro.php';
                die();
            }

            // Validación de longitud de contraseña
            if (strlen($password) < 6) {
                guardarMensaje("La contraseña debe tener al menos 6 caracteres");
                require 'app/vistas/registro.php';
                die();
            }

            // Validación de contraseñas similares
            if ($password !== $password2) {
                guardarMensaje("Las contraseñas no coinciden");
                require 'app/vistas/registro.php';
                die();
            }

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
                $usuario->setNombre($nombre);
                $usuario->setEmail($email);

                //encriptamos el password
                $passwordCifrado = password_hash($password, PASSWORD_DEFAULT);
                $usuario->setPassword($passwordCifrado);

                if ($usuariosDAO->insert($usuario)) {
                    // Iniciar sesión con el nuevo usuario
                    Sesion::iniciarSesion($usuario);

                    header("location: index.php");
                    guardarMensajeC("Registro realizado con éxito");
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
        guardarMensajeC("Sesion cerrada con éxito");
        header('location: index.php');
    }
}
