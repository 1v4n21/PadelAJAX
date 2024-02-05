<?php

//Uso de variables de sesión
session_start();

//Imports
require_once 'app/config/config.php';
require_once 'app/modelos/ConexionDB.php';
require_once 'app/modelos/Reserva.php';
require_once 'app/modelos/ReservasDAO.php';
require_once 'app/modelos/Tramo.php';
require_once 'app/modelos/TramosDAO.php';
require_once 'app/modelos/Usuario.php';
require_once 'app/modelos/UsuariosDAO.php';
require_once 'app/modelos/Sesion.php';
require_once 'app/utils/funciones.php';
require_once 'app/controladores/ControladorReservas.php';
require_once 'app/controladores/ControladorTramos.php';
require_once 'app/controladores/ControladorUsuarios.php';

//Mapa de enrutamiento
$mapa = array(
    'login' => array(
        'controlador' => 'ControladorUsuarios',
        'metodo' => 'login',
        'privada' => false
    ),
    'logout' => array(
        'controlador' => 'ControladorUsuarios',
        'metodo' => 'logout',
        'privada' => true
    ),
    'registrar' => array(
        'controlador' => 'ControladorUsuarios',
        'metodo' => 'registrar',
        'privada' => false
    ),
    'inicio' => array(
        'controlador' => 'ControladorTramos',
        'metodo' => 'inicio',
        'privada' => true
    ),
    'tramos' => array(
        'controlador' => 'ControladorTramos',
        'metodo' => 'tramos',
        'privada' => true
    ),
    'obtenerReservas' => array(
        'controlador' => 'ControladorReservas',
        'metodo' => 'obtenerReservas',
        'privada' => true
    ),
    'obtenerUsuario' => array(
        'controlador' => 'ControladorUsuarios',
        'metodo' => 'obtenerUsuario',
        'privada' => true
    ),
);


// Parseo de la ruta
if (isset($_GET['accion'])) {
    if (isset($mapa[$_GET['accion']])) {
        $accion = $_GET['accion'];
    } else {
        // La acción no existe
        header('Status: 404 Not found');
        echo 'Página no encontrada';
        die();
    }
} elseif (Sesion::existeSesion()) {
    $accion = 'inicio';   // Acción por defecto
} else {
    $accion = 'login';
}


//Si existe la cookie y no ha iniciado sesión, le iniciamos sesión de forma automática
//if( !isset($_SESSION['email']) && isset($_COOKIE['id'])){
if (!Sesion::existeSesion() && isset($_COOKIE['sid'])) {
    //Conectamos con la bD
    $connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

    //Nos conectamos para obtener el id
    $usuariosDAO = new UsuariosDAO($conn);
    if ($usuario = $usuariosDAO->getById($_COOKIE['sid'])) {
        Sesion::iniciarSesion($usuario);
        header('location: index.php');
        guardarMensajeC("Bienvenido " . $usuario->getNombre());
        die();
    }
}

//Si la acción es privada compruebo que ha iniciado sesión, sino, lo echamos a index
// if(!isset($_SESSION['email']) && $mapa[$accion]['privada']){
if (!Sesion::existeSesion() && $mapa[$accion]['privada']) {
    header('location: index.php');
    guardarMensaje("Debes iniciar sesión para acceder a $accion");
    die();
}

//$acción ya tiene la acción a ejecutar, cogemos el controlador y metodo a ejecutar del mapa
$controlador = $mapa[$accion]['controlador'];
$metodo = $mapa[$accion]['metodo'];

//Ejecutamos el método de la clase controlador
$objeto = new $controlador();
$objeto->$metodo();
