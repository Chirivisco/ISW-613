<?php
session_start();
$usuario = $_SESSION["email"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu</title>
    <link rel="stylesheet" href="../stylesheets/styles_menu_admin.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <h1>Bienvenido, <b><?php echo $usuario; ?></b></h1>
        </div>
        <ul class="navbar-menu">
            <li><a href="crear_usuarios.php">Crear usuario</a></li>
            <li><a href="lista_usuarios.php">Ver usuarios</a></li>
        </ul>
    </nav>
</body>
</html>
