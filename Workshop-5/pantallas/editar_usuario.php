<?php
require '../utils/functions.php';

// Valida que haya un id en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $usuario = getUserById($id);
} else {
    header("Location: lista_usuarios.php?error=invalid_ID");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../stylesheets/styles_editar_usuario.css">
</head>
<body>
    <h1>Editar Usuario</h1>
    <form method="POST" action="../actions/editar_usuario.php?id=<?php echo $id; ?>">
        <div class="datos-form">
            <label for="username">Nombre de Usuario</label>
            <input id="username" type="text" name="username" value="<?php echo htmlspecialchars($usuario['USERNAME']); ?>" required>
        </div>
        <div class="datos-form">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required>
        </div>
        <div class="datos-form">
            <label for="tipo">Tipo</label>
            <select id="tipo" name="tipo" required>
                <option value="admin" <?php if ($usuario['tipo'] === 'admin') echo 'selected'; ?>>Admin</option>
                <option value="normal" <?php if ($usuario['tipo'] === 'normal') echo 'selected'; ?>>Normal</option>
            </select>
        </div>
        <button type="submit">Actualizar Usuario</button>
    </form>
</body>
</html>
