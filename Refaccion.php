<?php

declare(strict_types=1);
include("Conexion.php");

class Refaccion extends Conexion
{
    private $ID_R;
    private $Descripción;
    private $Precio;
    private $Stock;

    public function __construct()
    {
        parent::__construct();
    }

    public function Refaccion(int $ID_R, string $D_R, float $P_R, int $S)
    {
        $this->ID_R = $ID_R;
        $this->Descripción = $D_R;
        $this->Precio = $P_R;
        $this->Stock = $S;
    }

    public function getID_R(): int
    {
        return $this->ID_R;
    }

    public function setID_R(int $ID_R)
    {
        $this->ID_R = $ID_R;
    }

    public function getDescripcion_R(): string
    {
        return $this->Descripción;
    }

    public function setDescripcion_R(string $D_R)
    {
        $this->Descripción = $D_R;
    }

    public function getPrecio_R(): float
    {
        return $this->Precio;
    }

    public function setPrecio_R(float $P_R)
    {
        $this->Precio = $P_R;
    }

    public function getStock(): int
    {
        return $this->Stock;
    }

    public function setStock(int $S)
    {
        $this->Stock = $S;
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

    public function AgregarRefaccion()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "INSERT INTO refacciones (ID_R, Descripción, Precio, Stock) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issi", $this->ID_R, $this->Descripción, $this->Precio, $this->Stock);

        if ($stmt->execute()) {
            echo "Refacción agregada exitosamente.";
        } else {
            echo "Error al agregar la refacción: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function ModificarRefaccion()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "UPDATE refacciones SET Descripción = ?, Precio = ?, Stock = ? WHERE ID_R = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $this->Descripción, $this->Precio, $this->Stock, $this->ID_R);

        if ($stmt->execute()) {
            echo "Refacción modificada exitosamente.";
        } else {
            echo "Error al modificar la refacción: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function EliminarRefaccion()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "DELETE FROM refacciones WHERE ID_R = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->ID_R);

        if ($stmt->execute()) {
            echo "Refacción eliminada exitosamente.";
        } else {
            echo "Error al eliminar la refacción: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function ListaRefaccion()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "SELECT ID_R, Descripción, Precio, Stock FROM refacciones";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "ID de Refacción: " . $row['ID_R'] . "<br>";
                echo "Descripción: " . $row['Descripción'] . "<br>";
                echo "Precio: " . $row['Precio'] . "<br>";
                echo "Stock: " . $row['Stock'] . "<br>";
                echo "<hr>";
            }
        } else {
            echo "No se encontraron refacciones en la base de datos.";
        }

        $resultado->close();
        $conn->close();
    }
}


