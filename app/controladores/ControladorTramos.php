<?php

class ControladorTramos
{
    public function inicio()
    {
        //Incluyo la vista
        require 'app/vistas/inicio.php';
    }

    public function tramos()
    {
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos el objeto TramosDAO para acceder a BBDD a través de este objeto
        $tramosDAO = new TramosDAO($conn);
        $tramos = $tramosDAO->getAll();

        // Construir un array con la información de los tramos
        $tramosArray = [];

        foreach ($tramos as $tramo) {
            $tramosArray[] = [
                'hora' => $tramo->getHora(),
                'id' => $tramo->getId(),
            ];
        }

        // Imprimir el array como JSON
        print json_encode($tramosArray);
    }
}
