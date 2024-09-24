<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="styles_usuarios.css">
</head>

<body>
    <div class="contenedor">
        <h2>Lista de Usuarios Registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // conecta la base de datos
                $server = "localhost";
                $user = "root";
                $password = "";
                $db = "isw613-clase02";

                $conexion = new mysqli($server, $user, $password, $db);
                if ($conexion->connect_errno) {
                    die("Conexión fallida: " . $conexion->connect_errno);
                }

                // consulta los usuarios
                $sql = "SELECT id, nombre, apellido, telefono, correo FROM users";
                $resultado = $conexion->query($sql);

                if ($resultado->num_rows > 0) {
                    // va a mostrar los registros en una tabla
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $fila['id'] . "</td>";
                        echo "<td>" . $fila['nombre'] . "</td>";
                        echo "<td>" . $fila['apellido'] . "</td>";
                        echo "<td>" . $fila['telefono'] . "</td>";
                        echo "<td>" . $fila['correo'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay usuarios registrados.</td></tr>";
                }
                $conexion->close();
                ?>
            </tbody>
        </table>
        <a id="btn-regresar" href="index.php" class="btn">Regresar al Formulario</a>
    </div>
</body>

</html>
