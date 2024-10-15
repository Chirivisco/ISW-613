<?php

require '../utils/functions.php';

// Verifica si se envía una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verifica que se hayan enviado los campos requeridos
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['tipo'])) {
        // Comprobar que los campos no estén vacíos
        if ($_POST['username'] !== "" && $_POST['password'] !== "" && $_POST['tipo'] !== "") {
            $user['username'] = $_POST['username'];
            $user['password'] = $_POST['password'];
            $user['tipo'] = $_POST['tipo'];

            if (updateUser($id, $user)) {
                header("Location: ../pantallas/lista_usuarios.php");
                exit();
            } else {
                header("Location: ../pantallas/editar_usuario.php?id=$id&error=database_error");
                exit();
            }
        } else {
            header("Location: ../pantallas/editar_usuario.php?id=$id&error=empty_fields");
            exit();
        }
    } else {
        header("Location: ../pantallas/editar_usuario.php?id=$id&error=invalid_request");
        exit();
    }
}
