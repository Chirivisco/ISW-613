<?php

require '../utils/functions.php';

// Verificar si la solicitud es un POST y si se han enviado los campos requeridos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    
    // Comprobar que los campos no estén vacíos
    if ($_REQUEST['email'] !== "" && $_REQUEST['password'] !== "") {
        $user['email'] = $_REQUEST['email'];
        $user['password'] = $_REQUEST['password'];

        // Intentar autenticar al usuario usando la función login proveniente de 'functions.php'
        $resultado = login($user);

        // Validar si el login fue exitoso
        if ($resultado['success']) {
            if ($resultado['tipo'] === 'admin') {
                $datetime = gmdate('Y-m-d H:i:s');

                $user_id = getIdByUser($user['email']);

                // Setea la fecha y hora del login del usuario
                if(setLoginDateTime($user_id, $datetime)) {
                    header("Location: ../pantallas/menu_admin.php");
                }
                else {
                    header("Location: ../index.php?error=invalid_login_datetime");
                }
            } else {
                $datetime = gmdate('Y-m-d H:i:s');

                $user_id = getIdByUser($user['email']);

                // Setea la fecha y hora del login del usuario
                if(setLoginDateTime($user_id, $datetime)) {
                    header("Location: ../pantallas/menu_usuario.php");
                }
                else {
                    header("Location: ../index.php?error=invalid_login_datetime");
                }
                
            }
            exit();
        } else {
            // Redirigir de nuevo a la página de login con un mensaje de error
            header("Location: ../index.php?error=invalid_credentials");
            exit();
        }
    } else {
        // Si los campos están vacíos, redirigir con un mensaje de error
        header("Location: ../index.php?error=empty_fields");
        exit();
    }
} else {
    // Si la solicitud no es un POST, redirigir con un mensaje de error de solicitud inválida
    header("Location: ../index.php?error=invalid_request");
    exit();
}
