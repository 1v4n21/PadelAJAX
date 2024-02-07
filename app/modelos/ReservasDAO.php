<?php
class ReservasDAO
{
    private mysqli $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getById($id): ?Reserva
    {
        if (!$stmt = $this->conn->prepare("SELECT * FROM reservas WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            $reserva = $result->fetch_object(Reserva::class);
            return $reserva;
        } else {
            return null;
        }
    }

    public function getAll(): array
    {
        if (!$stmt = $this->conn->prepare("SELECT * FROM reservas")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $array_reservas = array();

        while ($reserva = $result->fetch_object(Reserva::class)) {
            $array_reservas[] = $reserva;
        }
        return $array_reservas;
    }

    public function getByUserId($userId): array
    {
        if (!$stmt = $this->conn->prepare("SELECT * FROM reservas WHERE idUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        $stmt->bind_param('s', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $array_reservas = array();

        while ($reserva = $result->fetch_object(Reserva::class)) {
            $array_reservas[] = $reserva;
        }
        return $array_reservas;
    }

    public function getByIdAndUserId($id, $userId): ?Reserva
    {
        if (!$stmt = $this->conn->prepare("SELECT * FROM reservas WHERE id = ? AND idUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        $stmt->bind_param('ss', $id, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            $reserva = $result->fetch_object(Reserva::class);
            return $reserva;
        } else {
            return null;
        }
    }

    public function insert(Reserva $reserva): int|bool
    {
        if (!$stmt = $this->conn->prepare("INSERT INTO reservas (idUsuario, idTramo, fecha) VALUES (?,?,?)")) {
            die("Error al preparar la consulta insert: " . $this->conn->error);
        }

        $idUsuario = $reserva->getIdUsuario();
        $idTramo = $reserva->getIdTramo();
        $fecha = $reserva->getFecha();

        $stmt->bind_param('sss', $idUsuario, $idTramo, $fecha);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function delete($id): bool
    {
        if (!$stmt = $this->conn->prepare("DELETE FROM reservas WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param('s', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getByFecha($fecha): array
    {
        if (!$stmt = $this->conn->prepare("SELECT * FROM reservas WHERE fecha = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        $stmt->bind_param('s', $fecha);
        $stmt->execute();
        $result = $stmt->get_result();

        $array_reservas = array();

        while ($reserva = $result->fetch_object(Reserva::class)) {
            $array_reservas[] = $reserva;
        }

        return $array_reservas;
    }
}
