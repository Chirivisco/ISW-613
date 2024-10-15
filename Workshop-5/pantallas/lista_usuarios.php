<?php
require '../utils/functions.php';

// Obtiene la lista de usuarios
$usuarios = getUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="../stylesheets/styles_lista_usuarios.css">
</head>
<body>
    <h1>Lista de Usuarios</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Usuario</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['ID']; ?></td>
                    <td><?php echo htmlspecialchars($usuario['USERNAME']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['tipo']); ?></td>
                    <td>
                        <a href="editar_usuario.php?id=<?php echo $usuario['ID']; ?>">Editar</a>
                        <a href="../actions/eliminar_usuario.php?id=<?php echo $usuario['ID']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
