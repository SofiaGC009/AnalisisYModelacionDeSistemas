<?php

declare(strict_types=1);

require_once 'Conexion.php';

class Empleado extends Conexion
{
    private $ID_U;
    private $Nombre_E;
    private $Apellido_E;
    private $Usuario;
    private $Contraseña;
    
    private $ID_Rol;

    public function __construct(int $ID_U, string $N_E, string $A_E, string $U, string $C, int $ID_Rol)
    {
        $this->ID_U = $ID_U;
        $this->Nombre_E = $N_E;
        $this->Apellido_E = $A_E;
        $this->Usuario = $U;
        $this->Contraseña = $C;
        $this->ID_Rol = $ID_Rol;
        parent::__construct();
    }

    public function Empleado(int $ID_U, string $N_E, string $A_E, string $U, string $C, int $ID_Rol)
    {
        $this->ID_U = $ID_U;
        $this->Nombre_E = $N_E;
        $this->Apellido_E = $A_E;
        $this->Usuario = $U;
        $this->Contraseña = $C;
        $this->ID_Rol = $ID_Rol;
    }

    public function getID_U(): int
    {
        return $this->ID_U;
    }

    public function setID_U(int $ID_U)
    {
        $this->ID_U = $ID_U;
    }

    public function getNombre_E(): string
    {
        return $this->Nombre_E;
    }

    public function setNombre_E(string $N_E)
    {
        $this->Nombre_E = $N_E;
    }

    public function getApellido_E(): string
    {
        return $this->Apellido_E;
    }

    public function setApellido_E(string $A_E)
    {
        $this->Apellido_E = $A_E;
    }

    public function getUsuario(): string
    {
        return $this->Usuario;
    }

    public function setUsuario(string $U)
    {
        $this->Usuario = $U;
    }

    public function getContraseña(): string
    {
        return $this->Contraseña;
    }

    public function setContraseña(string $C)
    {
        $this->Contraseña = $C;
    }

    public function getID_Rol(): int
    {
        return $this->ID_Rol;
    }

    public function setID_Rol(int $ID_Rol)
    {
        $this->ID_Rol = $ID_Rol;
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

    public function AgregarEmpleado(Empleado $nuevoEmpleado)
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "INSERT INTO empleados (ID_U, Nombre_E, Apellido_E, Usuario, Contraseña, ID_Rol) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssi",$nuevoEmpleado->getID_U(), $nuevoEmpleado->getNombre_E(), $nuevoEmpleado->getApellido_E(), $nuevoEmpleado->getUsuario(), $nuevoEmpleado->getContraseña(), $nuevoEmpleado->getID_Rol());

        if ($stmt->execute()) {
            echo "Empleado agregado exitosamente.";
        } else {
            echo "Error al agregar el empleado: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function ModificarEmpleado()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "UPDATE empleados SET Nombre_E = ?, Apellido_E = ?, Usuario = ?, Contraseña = ?, ID_Rol = ? WHERE ID_E = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $this->Nombre_E, $this->Apellido_E, $this->Usuario, $this->Contraseña, $this->ID_Rol, $this->ID_U);

        if ($stmt->execute()) {
            echo "Empleado modificado exitosamente.";
        } else {
            echo "Error al modificar el empleado: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function EliminarEmpleado()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "DELETE FROM empleados WHERE ID_E = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->ID_U);

        if ($stmt->execute()) {
            echo "Empleado eliminado exitosamente.";
        } else {
            echo "Error al eliminar el empleado: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    public function ListaEmpleado()
    {
        // Obtener la conexión a la base de datos
        $conn = $this->getConexion();

        $sql = "SELECT ID_U, Nombre_E, Apellido_E, Usuario, Contraseña, ID_Rol FROM empleados";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "ID de Empleado: " . $row['ID_U'] . "<br>";
                echo "Nombre: " . $row['Nombre_E'] . "<br>";
                echo "Apellido: " . $row['Apellido_E'] . "<br>";
                echo "Usuario: " . $row['Usuario'] . "<br>";
                echo "Contraseña: " . $row['Contraseña'] . "<br>";
                echo "ID de Rol: " . $row['ID_Rol'] . "<br>";
                echo "<hr>";
            }
        } else {
            echo "No se encontraron empleados en la base de datos.";
        }

        $resultado->close();
        $conn->close();
    }
}
