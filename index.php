<?php

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

//Uso de variables de sesión
session_start();

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
);

//Parseo de la ruta
if (isset($_GET['accion'])) { //Compruebo si me han pasado una acción concreta, sino pongo la accción por defecto login
    if (isset($mapa[$_GET['accion']])) {  //Compruebo si la accción existe en el mapa, sino muestro error 404
        $accion = $_GET['accion'];
    } else {
        //La acción no existe
        header('Status: 404 Not found');
        echo 'Página no encontrada';
        die();
    }
} else {
    $accion = 'login';   //Acción por defecto
}

//Si existe la cookie y no ha iniciado sesión, le iniciamos sesión de forma automática
//if( !isset($_SESSION['email']) && isset($_COOKIE['id'])){
if (!Sesion::existeSesion() && isset($_COOKIE['id'])) {
    //Conectamos con la bD
    $connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

    //Nos conectamos para obtener el id y la foto del usuario
    $usuariosDAO = new UsuariosDAO($conn);
    if ($usuario = $usuariosDAO->getByid($_COOKIE['id'])) {
        Sesion::iniciarSesion($usuario);
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
