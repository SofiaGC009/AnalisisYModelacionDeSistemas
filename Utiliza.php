<?php

declare(strict_types=1);
include("Conexion.php");

class Utiliza extends Conexion
{
    private $ID_S;
    private $ID_R;

    public function __construct(int $ID_S, int $ID_R)
    {
        $this->ID_S = $ID_S;
        $this->ID_R = $ID_R;
        parent::__construct();
    }

    public function Utiliza(int $ID_S, int $ID_R)
    {
        $this->ID_S = $ID_S;
        $this->ID_R = $ID_R;
    }

    public function getID_S(): int
    {
        return $this->ID_S;
    }

    public function setID_S(int $ID_S)
    {
        $this->ID_S = $ID_S;
    }

    public function getID_R(): int
    {
        return $this->ID_R;
    }

    public function setID_R(int $ID_R)
    {
        $this->ID_R = $ID_R;
    }

    private function getConexion()
    {
        // Obtener la instancia de la conexión desde la clase padre (Conexion)
        $conexion = $this->db_conn;
        
        // Verificar si la conexión está establecida
        if ($conexion instanceof mysqli && $conexion->connect_error) {
            echo "Error de conexión: " . $conexion->connect_error;
            return null;
        }
        return $this->db_conn;
    }

    public function AgregarUtiliza(Utiliza $obj)
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "INSERT INTO utiliza (ID_S, ID_R) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $obj->getID_S(), $obj->getID_R());

        if ($stmt->execute()) {
            echo "Referencia agregada exitosamente a la lista de utilizadas.";
        } else {
            echo "Error al agregar la referencia a la lista de utilizadas: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function ModificarUtiliza(Utiliza $obj)
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "UPDATE utiliza SET ID_R = ? WHERE ID_S = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $obj->getID_R(), $obj->getID_S());

        if ($stmt->execute()) {
            echo "Referencia modificada exitosamente en la lista de utilizadas.";
        } else {
            echo "Error al modificar la referencia en la lista de utilizadas: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function EliminarUtiliza(int $ID_S, int $ID_R)
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "DELETE FROM utiliza WHERE ID_S = ? AND ID_R = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $ID_S, $ID_R);

        if ($stmt->execute()) {
            echo "Referencia eliminada exitosamente de la lista de utilizadas.";
        } else {
            echo "Error al eliminar la referencia de la lista de utilizadas: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    public function ListaUtiliza(int $ID_S)
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "SELECT ID_R FROM utiliza WHERE ID_S = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ID_S);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            $referenciasUtilizadas = [];

            while ($row = $resultado->fetch_assoc()) {
                $referenciasUtilizadas[] = $row['ID_R'];
            }

            // Aquí tienes el array con los ID de las referencias utilizadas por el servicio
            print_r($referenciasUtilizadas);
        } else {
            echo "Error al obtener las referencias utilizadas: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
