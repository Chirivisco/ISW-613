<?php

require '../utils/functions.php';

// Verifica que se haya enviado un ID por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Llama a la función deleteUser para eliminar al usuario
    if (deleteUser($id)) {
        header("Location: ../pantallas/lista_usuarios.php");
        exit();
    } else {
        header("Location: ../pantallas/lista_usuarios.php?error=database_error");
        exit();
    }
} else {
    header("Location: ../pantallas/lista_usuarios.php?error=invalid_request");
    exit();
}
