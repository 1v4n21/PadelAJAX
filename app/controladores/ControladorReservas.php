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

    public function crearReserva()
    {

        if (isset($_GET['idUsuario']) && isset($_GET['idTramo']) && isset($_GET['fecha'])) {
            // Obtener los valores de los parámetros
            $idUsuario = $_GET['idUsuario'];
            $idTramo = $_GET['idTramo'];
            $fecha = $_GET['fecha'];

            // Creamos la conexión utilizando la clase que hemos creado
            $connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            $reservasDAO = new ReservasDAO($conn);
            $reserva = new Reserva();
            $reserva->setIdUsuario($idUsuario);
            $reserva->setIdTramo($idTramo);
            $reserva->setFecha($fecha);

            //Validamos que se crea la reserva correctamente
            if ($idReserva = $reservasDAO->insert($reserva)) {
                print json_encode(['respuesta' => 'ok', 'idReserva' => $idReserva]);
            } else {
                print json_encode(['respuesta' => 'error', 'mensaje' => 'Error al realizar la reserva']);
            }

            //Tiempo de espera
            sleep(1);
        }
    }

    public function borrarReserva()
    {
        if (isset($_GET['idReserva'])) {
            // Obtener los valores de los parámetros
            $idReserva = $_GET['idReserva'];

            // Creamos la conexión utilizando la clase que hemos creado
            $connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            $reservasDAO = new ReservasDAO($conn);

            //Validamos que se borra la reserva correctamente
            if ($reservasDAO->delete($idReserva)) {
                print json_encode(['respuesta' => 'ok']);
            } else {
                print json_encode(['respuesta' => 'error', 'mensaje' => 'Error al borrar la reserva']);
            }

            //Tiempo de espera
            sleep(1);
        }
    }
}
