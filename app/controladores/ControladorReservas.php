<?php

class ControladorReservas
{

    public function obtenerReservas()
    {
        // Verificamos si existe el parámetro 'fecha' en la URL
        if (isset($_GET['fecha'])) {
            // Obtener la fecha pasada por GET
            $fecha = htmlentities($_GET['fecha']);

            // Creamos la conexión utilizando la clase que hemos creado
            $connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            $reservasDAO = new ReservasDAO($conn);
            $reservas = $reservasDAO->getByFecha($fecha);

            // Construir un array con la información de los tramos
            $reservasArray = [];

            foreach ($reservas as $reserva) {
                $reservasArray[] = [
                    'idUsuario' => $reserva->getIdUsuario(),
                    'idTramo' => $reserva->getIdTramo(),
                    'idReserva' => $reserva->getId()
                ];
            }

            // Imprimir el array como JSON
            print json_encode($reservasArray);
        } else {
            echo "No se ha proporcionado la fecha en la URL";
        }
    }
}
