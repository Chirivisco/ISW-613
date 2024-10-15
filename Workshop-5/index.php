<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="stylesheets/styles_login.css">
</head>
<body>
    <?php
        include('utils/functions.php');
        $error_msg = isset($_GET['error']) ? $_GET['error'] : '';
    ?>
    <form method="POST" action="actions/inicio_sesion.php">
        <div id="error">
            <?php echo $error_msg; ?>
        </div>
        <div class="datos-form">
            <label for="email">Correo electrónico</label>
            <input id="email" type="text" name="email">
        </div>
        <div class="datos-form">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password">
        </div>
        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>
