<?php

declare(strict_types=1);
include("Conexion.php");

class ArrayList
{
    private $array;

    public function __construct()
    {
        $this->array = array();
    }

    public function add($item)
    {
        $this->array[] = $item;
    }

    public function get($index)
    {
        return $this->array[$index] ?? null;
    }

    public function size()
    {
        return count($this->array);
    }
}

class Servicio extends Conexion
{
    private $ID_S;
    private $Fecha;
    private $Descripción;
    private $Estado;

    private $ID_U;
    private $ID_A;
    private $ID_CS;
    private $ID_C;

    private $refacciones; // ArrayList<Refaccion>

    public function __construct()
    {
        parent::__construct();
        $this->refacciones = new ArrayList();
    }

    public function Servicio(int $ID_S, string $F, string $D_S, string $E, int $ID_U, int $ID_A, int $ID_CS, int $ID_C)
    {
        $this->ID_S = $ID_S;
        $this->Fecha = $F;
        $this->Descripción = $D_S;
        $this->Estado = $E;
        $this->ID_U = $ID_U;
        $this->ID_A = $ID_A;
        $this->ID_CS = $ID_CS;
        $this->ID_C = $ID_C;
    }

    public function getID_S(): int
    {
        return $this->ID_S;
    }

    public function setID_S(int $ID_S)
    {
        $this->ID_S = $ID_S;
    }

    public function getFecha(): string
    {
        return $this->Fecha;
    }

    public function setFecha(string $F)
    {
        $this->Fecha = $F;
    }

    public function getDescripcion_S(): string
    {
        return $this->Descripción;
    }

    public function setDescripcion_S(string $D_S)
    {
        $this->Descripción = $D_S;
    }

    public function getEstado(): string
    {
        return $this->Estado;
    }

    public function setEstado(string $E)
    {
        $this->Estado = $E;
    }

    public function getID_U(): int
    {
        return $this->ID_U;
    }

    public function setID_U(int $ID_U)
    {
        $this->ID_U = $ID_U;
    }

    public function getID_A(): int
    {
        return $this->ID_A;
    }

    public function setID_A(int $ID_A)
    {
        $this->ID_A = $ID_A;
    }

    public function getID_CS(): int
    {
        return $this->ID_CS;
    }

    public function setID_CS(int $ID_CS)
    {
        $this->ID_CS = $ID_CS;
    }

    public function getID_C(): int
    {
        return $this->ID_C;
    }

    public function setID_C(int $ID_C)
    {
        $this->ID_C = $ID_C;
    }

    public function getConexion()
    {
        // Obtener la instancia de la conexión desde la clase padre (Conexion)
        $conexion = $this->db_conn;
    
        // Verificar si la conexión está establecida
        if ($conexion instanceof mysqli && $conexion->connect_error) {
            echo "Error de conexión: " . $conexion->connect_error;
            return null;
        }
    
        return $conexion;
    }

    public function AgregarServicio()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "INSERT INTO servicios (ID_S, Fecha, Descripcion, Estado, ID_U, ID_A, ID_CS, ID_C) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssiiii", $this->ID_S, $this->Fecha, $this->Descripción, $this->Estado, $this->ID_U, $this->ID_A, $this->ID_CS, $this->ID_C);

        if ($stmt->execute()) {
            echo "Servicio agregado exitosamente.";
        } else {
            echo "Error al agregar el servicio: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function ModificarServicio()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "UPDATE servicios SET Fecha = ?, Descripcion = ?, Estado = ?, ID_U = ?, ID_A = ?, ID_CS = ?, ID_C = ? WHERE ID_S = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiiiii", $this->Fecha, $this->Descripción, $this->Estado, $this->ID_U, $this->ID_A, $this->ID_CS, $this->ID_C, $this->ID_S);

        if ($stmt->execute()) {
            echo "Servicio modificado exitosamente.";
        } else {
            echo "Error al modificar el servicio: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function EliminarServicio()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "DELETE FROM servicios WHERE ID_S = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->ID_S);

        if ($stmt->execute()) {
            echo "Servicio eliminado exitosamente.";
        } else {
            echo "Error al eliminar el servicio: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function ListaServicio()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "SELECT ID_S, Fecha, Descripcion, Estado, ID_U, ID_A, ID_CS, ID_C FROM servicios";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "ID de Servicio: " . $row['ID_S'] . "<br>";
                echo "Fecha: " . $row['Fecha'] . "<br>";
                echo "Descripción: " . $row['Descripcion'] . "<br>";
                echo "Estado: " . $row['Estado'] . "<br>";
                echo "ID de Usuario: " . $row['ID_U'] . "<br>";
                echo "ID de Atención: " . $row['ID_A'] . "<br>";
                echo "ID de Categoría de Servicio: " . $row['ID_CS'] . "<br>";
                echo "ID de Cliente: " . $row['ID_C'] . "<br>";
                echo "<hr>";
            }
        } else {
            echo "No se encontraron servicios en la base de datos.";
        }

        $resultado->close();
        $conn->close();
    }

    public function getRefaccion(): ArrayList
    {
        return $this->refacciones;
    }

    public function setRefaccion(ArrayList $refacciones)
    {
        $this->refacciones = $refacciones;
    }
}
