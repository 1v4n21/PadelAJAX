<?php

class ControladorTramos {
    public function inicio(){

        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //Creamos el objeto TramosDAO para acceder a BBDD a través de este objeto
        $tramosDAO = new TramosDAO($conn);
        $tramos = $tramosDAO->getAll();

        //Incluyo la vista
        require 'app/vistas/inicio.php';
    }
}