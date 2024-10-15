<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuarios</title>
    <link rel="stylesheet" href="../stylesheets/styles_crear_usuarios.css">
</head>
<body>
    <div class="container">
        <h1>Crear Usuario</h1>
        <form method="POST" action="../actions/nuevo_usuario.php">
            <div class="form-group">
                <label for="username">Nombre de Usuario</label>
                <input id="username" type="text" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo de Usuario</label>
                <select id="tipo" name="tipo" required>
                    <option value="admin">Admin</option>
                    <option value="normal">Normal</option>
                </select>
            </div>
            <button type="submit">Crear Usuario</button>
        </form>
    </div>
</body>
</html>
