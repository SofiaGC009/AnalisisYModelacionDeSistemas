<?php

declare(strict_types=1);
include("Conexion.php");

class CatalogoServicios extends Conexion
{

    private $ID_CS;
    private $Nombre_CS;
    private $Descripción_CS;
    private $Precio_CS;

    public function __construct()
    {
        parent::__construct();
    }

    public function CatalogoServicios(int $ID_CS, string $N_CS, string $D_CS, float $P_CS)
    {
        $this->ID_CS = $ID_CS;
        $this->Nombre_CS = $N_CS;
        $this->Descripción_CS = $D_CS;
        $this->Precio_CS = $P_CS;
    }

    public function getID_CS(): int
    {
        return $this->ID_CS;
    }

    public function setID_CS(int $ID_CS)
    {
        $this->ID_CS = $ID_CS;
    }

    public function getNombre_CS(): string
    {
        return $this->Nombre_CS;
    }

    public function setNombre_CS(string $N_CS)
    {
        $this->Nombre_CS = $N_CS;
    }

    public function getDescripcion_CS(): string
    {
        return $this->Descripción_CS;
    }

    public function setDescripcion_CS(string $D_CS)
    {
        $this->Descripción_CS = $D_CS;
    }

    public function getPrecio_CS(): float
    {
        return $this->Precio_CS;
    }

    public function setPrecio_CS(float $P_CS)
    {
        $this->Precio_CS = $P_CS;
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

    public function AgregarCatalogoServicio()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "INSERT INTO catalogo_servicios (Nombre_CS, Descripcion_CS, Precio_CS) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $this->Nombre_CS, $this->Descripción_CS, $this->Precio_CS);

        if ($stmt->execute()) {
            echo "Servicio agregado exitosamente.";
        } else {
            echo "Error al agregar el servicio: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function ModificarCatalogoServicio()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "UPDATE catalogo_servicios SET Nombre_CS = ?, Descripcion_CS = ?, Precio_CS = ? WHERE ID_CS = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $this->Nombre_CS, $this->Descripción_CS, $this->Precio_CS, $this->ID_CS);

        if ($stmt->execute()) {
            echo "Servicio modificado exitosamente.";
        } else {
            echo "Error al modificar el servicio: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function EliminarCatalogoServicio()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "DELETE FROM catalogo_servicios WHERE ID_CS = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->ID_CS);

        if ($stmt->execute()) {
            echo "Servicio eliminado exitosamente.";
        } else {
            echo "Error al eliminar el servicio: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    public function ListaCatalogoServicios()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "SELECT ID_CS, Nombre_CS, Descripcion_CS, Precio_CS FROM catalogo_servicios";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "ID de Servicio: " . $row['ID_CS'] . "<br>";
                echo "Nombre: " . $row['Nombre_CS'] . "<br>";
                echo "Descripción: " . $row['Descripcion_CS'] . "<br>";
                echo "Precio: " . $row['Precio_CS'] . "<br>";
                echo "<hr>";
            }
        } else {
            echo "No se encontraron servicios en el catálogo.";
        }

        $resultado->close();
        $conn->close();
    }
}
