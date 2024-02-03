<?php
class TramosDAO
{
    private mysqli $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getById($id): ?Tramo
    {
        if (!$stmt = $this->conn->prepare("SELECT * FROM tramos WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            $tramo = $result->fetch_object(Tramo::class);
            return $tramo;
        } else {
            return null;
        }
    }

    public function getAll(): array
    {
        if (!$stmt = $this->conn->prepare("SELECT * FROM tramos")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $array_tramos = array();

        while ($tramo = $result->fetch_object(Tramo::class)) {
            $array_tramos[] = $tramo;
        }
        return $array_tramos;
    }

    public function insert(Tramo $tramo): int|bool
    {
        if (!$stmt = $this->conn->prepare("INSERT INTO tramos (hora) VALUES (?)")) {
            die("Error al preparar la consulta insert: " . $this->conn->error);
        }

        $hora = $tramo->getHora();

        $stmt->bind_param('s', $hora);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }
}
