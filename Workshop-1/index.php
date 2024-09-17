<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fecha y Hora Actual - Costa Rica</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <div id="info">
        <h1>Fecha y Hora Actual - Costa Rica</h1>
        <p class="datetime">
            <?php
            date_default_timezone_set('America/Costa_Rica');
            echo date('Y-m-d H:i:s');
            ?>
        </p>
    </div>
</body>
</html>
