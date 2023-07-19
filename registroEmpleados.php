<?php
declare(strict_types=1);
require_once 'Empleado.php';

// Verificar si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los valores del formulario
    $ID_E = $_POST["id_empleado"] ?? '';
    $N_E = $_POST["nombre_empleado"] ?? '';
    $A_E = $_POST["apellido_empleado"] ?? '';
    $U = $_POST["usuario"] ?? '';
    $C = $_POST["contraseña"] ?? '';
    $ID_Rol = $_POST["rol"] ?? '';

    // Asegúrate de que las variables tengan valores válidos antes de crear la instancia
    if (empty($ID_E) || empty($N_E) || empty($A_E) || empty($U) || empty($C) || empty($ID_Rol)) {
        echo "Por favor, completa todos los campos.";
        exit;
    }

    // Crear una nueva instancia de Empleado con los datos del formulario
    $nuevoEmpleado = new Empleado((int)$ID_E, $N_E, $A_E, $U, $C, (int)$ID_Rol);
    $empleado = new Empleado();
    // Agregar el empleado a la base de datos
    $empleado->AgregarEmpleado($nuevoEmpleado);
    echo "Empleado registrado exitosamente.";

    // Puedes redirigir al empleado a una página de inicio después del registro
    // header("Location: inicio.php");
    // exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empleado</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #AEE7AE;
            margin: 0;
            padding: 0;
        }
        .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Ajusta la altura del contenedor al 100% del viewport */
    }

        h1 {
            text-align: center;
            margin-top: 40px;
            color: #FCACAC;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        label,
        input,
        select {
            display: block;
            margin-bottom: 10px;
        }

        label {
            font-weight: bold;
            color: #FCACAC;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #FCACAC;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #F35E5E;
        }

        .error-message {
            color: #d9534f;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>

<body>
    <h1>Registro de Empleado</h1>
    <form action="registroEmpleados.php" method="post">
    <label for="id_empleado">ID Empleado:</label>
        <input type="text" id="id_empleado" name="id_empleado" required><br>

        <label for="nombre_empleado">Nombre:</label>
        <input type="text" id="nombre_empleado" name="nombre_empleado" required><br>

        <label for="apellido_empleado">Apellido:</label>
        <input type="text" id="apellido_empleado" name="apellido_empleado" required><br>

        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>
        <span class="error-message" id="contrasena-error"></span><br>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol" required>
            <option value="1">Administrador</option>
            <option value="2">Gerente</option>
            <option value="3">Servicio de Ventas</option>
            <option value="4">Atención al Cliente</option>
            <option value="5">Mecánico</option>
        </select><br>

        <input type="submit" value="Registrar Empleado">
    </form>
</body>

</html>
