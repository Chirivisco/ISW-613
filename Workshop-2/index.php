<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User registration</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
    <div class="contenedor">
        <h2>Formulario de Registro</h2>
        <form method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>

            <button type="submit">Enviar</button>
        </form>

        <?php
        // conecta la base de datos
        $server = "localhost";
        $user = "root";
        $password = "";
        $db = "isw613-clase02";

        $conexion = new mysqli($server, $user, $password, $db);
        if ($conexion->connect_errno) {
            die("Conexion fallida" . $conexion->connect_errno);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellido = htmlspecialchars($_POST['apellido']);
            $telefono = htmlspecialchars($_POST['telefono']);
            $correo = htmlspecialchars($_POST['correo']);

            // insert del sql
            $sql = "INSERT INTO users (nombre, apellido, telefono, correo) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssss", $nombre, $apellido, $telefono, $correo);

            // ejecuta el insert
            if ($stmt->execute()) {
                header("Location: usuarios.php");
            } else {
                echo "<div class='result'><h3>Error al registrar: " . $stmt->error . "</h3></div>";
            }            

            // cierre de la consulta
            $stmt->close();
        }
        $conexion->close();
        ?>
    </div>
</body>

</html>