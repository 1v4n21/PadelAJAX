<?php
class UsuariosDAO
{
    private mysqli $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getByEmail($email): Usuario|null
    {
        if (!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        } else {
            return null;
        }
    }

    public function getById($id)
    {
        if (!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        } else {
            return null;
        }
    }

    public function getAll(): array
    {
        if (!$stmt = $this->conn->prepare("SELECT * FROM usuarios")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $array_usuarios = array();

        while ($usuario = $result->fetch_object(Usuario::class)) {
            $array_usuarios[] = $usuario;
        }
        return $array_usuarios;
    }

    public function insert(Usuario $usuario): int|bool
    {
        if (!$stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?,?,?)")) {
            die("Error al preparar la consulta insert: " . $this->conn->error);
        }

        $nombre = $usuario->getNombre();
        $email = $usuario->getEmail();
        $password = $usuario->getPassword();

        $stmt->bind_param('sss', $nombre, $email, $password);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function getByEmailAndPassword($email, $password): ?Usuario
    {
        if (!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ? AND password = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        } else {
            return null;
        }
    }
}
