<?php

declare(strict_types=1);

require_once 'Conexion.php';

class Cliente extends Conexion
{
    private $ID_C;
    private $Nombre;
    private $Apellido;
    private $Dirección;
    private $Teléfono;
    private $Correo;

    public function __construct()
    {
        parent::__construct();
    }

    public function Cliente(int $ID_C, string $N, string $A, string $D, string $T, string $C)
    {
        $this->ID_C = $ID_C;
        $this->Nombre = $N;
        $this->Apellido = $A;
        $this->Dirección = $D;
        $this->Teléfono = $T;
        $this->Correo = $C;
    }

    public function getID_C(): int
    {
        return $this->ID_C;
    }

    public function setID_C(int $ID_C)
    {
        $this->ID_C = $ID_C;
    }

    public function getNombre_C(): string
    {
        return $this->Nombre;
    }

    public function setNombre_C(string $N)
    {
        $this->Nombre = $N;
    }

    public function getApellido_C(): string
    {
        return $this->Apellido;
    }

    public function setApellido_C(string $A)
    {
        $this->Apellido = $A;
    }

    public function getDireccion(): string
    {
        return $this->Dirección;
    }

    public function setDireccion(string $D)
    {
        $this->Dirección = $D;
    }

    public function getTelefono(): string
    {
        return $this->Teléfono;
    }

    public function setTelefono(string $T)
    {
        $this->Teléfono = $T;
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

    public function AgregarCliente()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "INSERT INTO clientes (Nombre, Apellido, Dirección, Teléfono, Correo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $this->Nombre, $this->Apellido, $this->Dirección, $this->Teléfono, $this->Correo);

        if ($stmt->execute()) {
            echo "Cliente agregado exitosamente.";
        } else {
            echo "Error al agregar el cliente: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function ModificarCliente()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "UPDATE clientes SET Nombre = ?, Apellido = ?, Dirección = ?, Teléfono = ?, Correo = ? WHERE ID_C = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $this->Nombre, $this->Apellido, $this->Dirección, $this->Teléfono, $this->Correo, $this->ID_C);

        if ($stmt->execute()) {
            echo "Cliente modificado exitosamente.";
        } else {
            echo "Error al modificar el cliente: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function EliminarCliente()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "DELETE FROM clientes WHERE ID_C = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->ID_C);

        if ($stmt->execute()) {
            echo "Cliente eliminado exitosamente.";
        } else {
            echo "Error al eliminar el cliente: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function ListaCliente()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "SELECT ID_C, Nombre, Apellido, Dirección, Teléfono, Correo FROM clientes";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "ID de Cliente: " . $row['ID_C'] . "<br>";
                echo "Nombre: " . $row['Nombre'] . "<br>";
                echo "Apellido: " . $row['Apellido'] . "<br>";
                echo "Dirección: " . $row['Dirección'] . "<br>";
                echo "Teléfono: " . $row['Teléfono'] . "<br>";
                echo "Correo: " . $row['Correo'] . "<br>";
                echo "<hr>";
            }
        } else {
            echo "No se encontraron clientes en la base de datos.";
        }

        $resultado->close();
        $conn->close();
    }
}
