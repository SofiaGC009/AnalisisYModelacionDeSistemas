<?php

declare(strict_types=1);
include("Conexion.php");

class Auto extends Conexion
{
    private $ID_A;
    private $Marca;
    private $Modelo;
    private $Año;
    private $Color;
    private $ID_C;

    public function __construct()
    {
        parent::__construct();
    }

    public function Auto(int $ID_A, string $Marca, string $Modelo, int $Año, string $Color, int $ID_C)
    {
        $this->ID_A = $ID_A;
        $this->Marca = $Marca;
        $this->Modelo = $Modelo;
        $this->Año = $Año;
        $this->Color = $Color;
        $this->ID_C = $ID_C;
    }

    public function getID_A(): int
    {
        return $this->ID_A;
    }

    public function setID_A(int $ID_A)
    {
        $this->ID_A = $ID_A;
    }

    public function getMarca(): string
    {
        return $this->Marca;
    }

    public function setMarca(string $Marca)
    {
        $this->Marca = $Marca;
    }

    public function getModelo(): string
    {
        return $this->Modelo;
    }

    public function setModelo(string $Modelo)
    {
        $this->Modelo = $Modelo;
    }

    public function getAño(): int
    {
        return $this->Año;
    }

    public function setAño(int $Año)
    {
        $this->Año = $Año;
    }

    public function getColor(): string
    {
        return $this->Color;
    }

    public function setColor(string $Color)
    {
        $this->Color = $Color;
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

    public function AgregarAuto()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "INSERT INTO Autos (ID_A, Marca, Modelo, Año, Color, ID_C) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssi", $this->ID_A, $this->Marca, $this->Modelo, $this->Año, $this->Color, $this->ID_C);

        if ($stmt->execute()) {
            echo "Auto agregado exitosamente.";
        } else {
            echo "Error al agregar el auto: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function ModificarAuto()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "UPDATE Autos SET Marca = ?, Modelo = ?, Año = ?, Color = ?, ID_C = ? WHERE ID_A = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $this->Marca, $this->Modelo, $this->Año, $this->Color, $this->ID_C, $this->ID_A);

        if ($stmt->execute()) {
            echo "Auto modificado exitosamente.";
        } else {
            echo "Error al modificar el auto: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function EliminarAuto()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "DELETE FROM Autos WHERE ID_A = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->ID_A);

        if ($stmt->execute()) {
            echo "Auto eliminado exitosamente.";
        } else {
            echo "Error al eliminar el auto: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function ListaAuto()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "SELECT ID_A, Marca, Modelo, Año, Color, ID_C FROM Autos";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "ID del Auto: " . $row['ID_A'] . "<br>";
                echo "Marca: " . $row['Marca'] . "<br>";
                echo "Modelo: " . $row['Modelo'] . "<br>";
                echo "Año: " . $row['Año'] . "<br>";
                echo "Color: " . $row['Color'] . "<br>";
                echo "ID del Cliente: " . $row['ID_C'] . "<br>";
                echo "<hr>";
            }
        } else {
            echo "No se encontraron autos en la base de datos.";
        }

        $resultado->close();
        $conn->close();
    }
}