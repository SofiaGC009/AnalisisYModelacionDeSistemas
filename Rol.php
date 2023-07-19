<?php

declare(strict_types=1);
include("Conexion.php");

class Rol extends Conexion
{
    private $ID_Rol;
    private $Nombre_Rol;

    public function __construct()
    {
        parent::__construct();
    }

    public function Rol(int $ID_Rol, string $N_Rol)
    {
        $this->ID_Rol = $ID_Rol;
        $this->Nombre_Rol = $N_Rol;
    }

    public function getID_Rol(): int
    {
        return $this->ID_Rol;
    }

    public function setID_Rol(int $ID_Rol)
    {
        $this->ID_Rol = $ID_Rol;
    }

    public function getNombre_Rol(): string
    {
        return $this->Nombre_Rol;
    }

    public function setNombre_Rol(string $N_Rol)
    {
        $this->Nombre_Rol = $N_Rol;
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

    return $conexion;
}

    public function AgregarRol()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "INSERT INTO rol (ID_Rol, Nombre_Rol) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $this->ID_Rol, $this->Nombre_Rol);

        if ($stmt->execute()) {
            echo "Rol agregada exitosamente.";
        } else {
            echo "Error al agregar el rol: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function ModificarRol()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "UPDATE rol SET Nombre_Rol = ? WHERE ID_Rol = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $this->Nombre_Rol, $this->ID_Rol);

        if ($stmt->execute()) {
            echo "Refacción modificada exitosamente.";
        } else {
            echo "Error al modificar la refacción: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function EliminarRol()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "DELETE FROM rol WHERE ID_Rol = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->ID_Rol);

        if ($stmt->execute()) {
            echo "Rol eliminado exitosamente.";
        } else {
            echo "Error al eliminar el Rol: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    

    public function ListaRol()
    {
        $conn = $this->getConexion();
        $sql = "SELECT ID_Rol, Nombre_Rol FROM roles";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "ID de Rol: " . $row['ID_Rol'] . "<br>";
                echo "Nombre de Rol: " . $row['Nombre_Rol'] . "<br>";
                echo "<hr>";
            }
        } else {
            echo "No se encontraron roles en la base de datos.";
        }

        $resultado->close();
        $conn->close();
    }
}
