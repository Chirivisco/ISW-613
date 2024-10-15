<?php

require 'utils/functions.php';

function updateInactiveUsers()
{
    $connection = getConnection();
    $users = getUsers();

    // Verificamos si la lista de usuarios fue obtenida
    if (!$users) {
        print "Error al cargar los usuarios.\n";
        return;
    } else {
        // carga la fecha y hora actual
        $tiempoActual = new DateTime();
        print "Hora actual: " . $tiempoActual->format('Y-m-d H:i:s') . "\n";

        foreach ($users as $user) {
            print "\nID: " . $user['ID'] . "." . "Username: " . $user['USERNAME'] . "\n";

            // Verifica si tiene fecha de login
            if (empty($user['FECHA_LOGIN'])) {
                print "Sin fecha \n\n";
                continue;
            }

            // Obtiene la fecha de login del usuario
            $fecha_login = new DateTime($user['FECHA_LOGIN']);

            // Hace la diferencia entre la fecha del login a la actual
            $diferencia = $tiempoActual->diff($fecha_login);

            print "Último login: " . $user['FECHA_LOGIN'] . " | Diferencia: " . $diferencia->format('%d días, %h horas') . "\n";

            // Valida que la diferencia no sea mayor a 24hrs
            if ($diferencia->h >= 24 || $diferencia->d >=1) {
                $query = "UPDATE USERS SET STATUS = 'I' WHERE ID = ?";

                try {
                    $stmt = $connection->prepare($query);
                    if (!$stmt) {
                        throw new Exception("Error en la consulta SQL: " . $connection->error);
                    }
                    $stmt->bind_param("i", $user['ID']);
                    if (!$stmt->execute()) {
                        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
                    } else {
                        print "{$user['USERNAME']} marcado inactivo.\n\n";
                    }
                } catch (Exception $e) {
                    error_log("Error al actualizar el usuario ID {$user['ID']}: " . $e->getMessage());
                } finally {
                    if (isset($stmt)) {
                        $stmt->close();
                    }
                }
            } else {
                print "{$user['USERNAME']} continua activo.\n\n";
            }
        }
    }

    mysqli_close($connection);
}

// Aquí ejecutamos el cronjob
updateInactiveUsers();
