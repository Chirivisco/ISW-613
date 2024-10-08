<?php

require '../utils/functions.php';

// Verificar si la solicitud es un POST y si se han enviado los campos requeridos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['tipo'])) {
    
    // Comprobar que los campos no estén vacíos
    if ($_REQUEST['username'] !== "" && $_REQUEST['password'] !== "" && $_REQUEST['tipo'] !== "") {
        $user['username'] = $_REQUEST['username'];
        $user['password'] = $_REQUEST['password'];
        $user['tipo'] = $_REQUEST['tipo'];

        // Intentar registrar al usuario usando la función signup proveniente de 'functions.php'
        if (signup($user)) {
            header("Location: /Workshop-4/pantallas/menu_admin.php");
            exit();
        } else {
            // Redirigir de nuevo a la página de registro con un mensaje de error
            header("Location: ../reg_usuarios.php?error=database_error");
            exit();
        }
    } else {
        // Si los campos están vacíos, redirigir con un mensaje de error
        header("Location: ../reg_usuarios.php?error=empty_fields");
        exit();
    }
} else {
    // Si la solicitud no es un POST, redirigir con un mensaje de error de solicitud inválida
    header("Location: ../reg_usuarios.php?error=invalid_request");
    exit();
}
