<?php

require '../utils/functions.php';

// Verificar si la solicitud es un POST y si se han enviado los campos requeridos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    
    // Comprobar que los campos no estén vacíos
    if ($_REQUEST['email'] !== "" && $_REQUEST['password'] !== "") {
        $user['email'] = $_REQUEST['email'];
        $user['password'] = $_REQUEST['password'];

        // Intentar autenticar al usuario usando la función login proveniente de 'functions.php'
        if (login($user)) {
            header("Location: ../pantallas/menu_admin.php");
            exit();
        } else {
            // Redirigir de nuevo a la página de login con un mensaje de error
            header("Location: ../index.php?error=invalid_credentials");
            exit();
        }
    } else {
        // Si los campos están vacíos, redirigir con un mensaje de error
        header("Location: ../index.php.php?error=empty_fields");
        exit();
    }
} else {
    // Si la solicitud no es un POST, redirigir con un mensaje de error de solicitud inválida
    header("Location: ../index.php.php?error=invalid_request");
    exit();
}
