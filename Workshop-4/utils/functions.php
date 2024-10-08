<?php

function getConnection(): bool|mysqli
{
  $connection = mysqli_connect('localhost', 'root', '', 'isw613-Clase04');
  print_r(mysqli_connect_error());
  return $connection;
}

// Función para iniciar una nueva sesión con un usuario
function login($user): bool
{
    // Obtiene la conexión a la base de datos
    $connection = getConnection();

    // Consulta SQL para autenticación de usuario y obtener el tipo
    $query = "SELECT PASSWORD, tipo FROM users WHERE USERNAME = ?";

    $username = $user['email'];
    $password = $user['password'];

    try {
        // Prepara la consulta SQL
        $stmt = $connection->prepare($query);

        if (!$stmt) {
            throw new Exception("Error en la consulta SQL: " . $connection->error);
        } else {
            // Vincula los parámetros (usuario)
            $stmt->bind_param("s", $username);

            // Ejecuta la consulta
            if ($stmt->execute()) {

                // Obtiene el resultado de la consulta
                $result = $stmt->get_result();

                // Valida que el resultado tenga filas
                if ($result->num_rows > 0) {
                    // Obtiene la contraseña hasheada y el tipo de usuario
                    $row = $result->fetch_assoc();
                    $hashed_password = $row['PASSWORD'];
                    $tipo_usuario = $row['tipo'];

                    // Valida la contraseña hasheada
                    if (password_verify($password, $hashed_password)) {
                        // Verifica si el tipo de usuario es 'admin'
                        if ($tipo_usuario === 'admin') {
                            session_start();
                            
                            $_SESSION["email"] = $username;
                            $_SESSION["tipo"] = $tipo_usuario;
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
        }
    } catch (Exception $e) {
        // Redirige en caso de error y detiene la ejecución
        header("Location: ../Workshop-4/index.php?error=database_error");
        exit();
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        mysqli_close($connection);
    }
    return false;
}

// Función para registrar un nuevo usuario
function signup($user): bool
{
    // Obtiene la conexión a la base de datos
    $connection = getConnection();

    // Consulta SQL para insertar un nuevo usuario
    $query = "INSERT INTO USERS (USERNAME, PASSWORD, tipo) VALUES (?, ?, ?)";

    // Obtiene el nombre de usuario, la contraseña y el tipo de usuario del array
    $username = $user['username'];
    $password = password_hash($user['password'], PASSWORD_DEFAULT); // Hashea la contraseña
    $tipo = $user['tipo'];

    try {
        $stmt = $connection->prepare($query);
        if (!$stmt) {
            throw new Exception("Error en la consulta SQL: " . $connection->error);
        } else {
            // Ingresa los parámetros o datos
            $stmt->bind_param("sss", $username, $password, $tipo);

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
        }
    } catch (Exception $e) {
        // Redirige en caso de error y detiene la ejecución
        header("Location: ../pantallas/reg_usuarios.php?error=database_error");
        exit();
    } finally {
        // Cierra la declaración y la conexión
        if (isset($stmt)) {
            $stmt->close();
        }
        mysqli_close($connection);
    }
}

// Función para obtener la lista de todos los usuarios
function getUsers(): array
{
    $connection = getConnection();

    $query = "SELECT * FROM USERS";

    $users = [];

    try {
        $stmt = $connection->prepare($query);
        if (!$stmt) {
            throw new Exception("Error en la consulta SQL: " . $connection->error);
        }

        if ($stmt->execute()) {
            // Obtiene el resultado de la consulta
            $result = $stmt->get_result();

            // Almacena los usuarios en el array
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        } else {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    } catch (Exception $e) {
        header("Location: ../index.php?error=database_error");
        exit();
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        mysqli_close($connection);
    }

    return $users;
}

// Función para obtener la info de un usuario por ID
function getUserById($id): array
{
    $connection = getConnection();
    $query = "SELECT ID, USERNAME, PASSWORD, tipo FROM USERS WHERE ID = ?";
    $user = [];

    try {
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
            }
        }
    } catch (Exception $e) {
        header("Location: ../index.php?error=database_error");
        exit();
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        mysqli_close($connection);
    }

    return $user;
}

// Función para actualizar un usuario
function updateUser($id, $user): bool
{
    $connection = getConnection();
    $query = "UPDATE USERS SET USERNAME = ?, PASSWORD = ?, tipo = ? WHERE ID = ?";

    $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $connection->prepare($query);
        if (!$stmt) {
            throw new Exception("Error en la consulta SQL: " . $connection->error);
        }

        $stmt->bind_param("sssi", $user['username'], $hashed_password, $user['tipo'], $id);

        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    } catch (Exception $e) {
        header("Location: ../index.php?error=database_error");
        exit();
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        mysqli_close($connection);
    }
}

// Función para eliminar un usuario
function deleteUser($id): bool
{
    $connection = getConnection();
    $query = "DELETE FROM USERS WHERE ID = ?";

    try {
        $stmt = $connection->prepare($query);
        if (!$stmt) {
            throw new Exception("Error en la consulta SQL: " . $connection->error);
        }

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    } catch (Exception $e) {
        header("Location: ../index.php?error=database_error");
        exit();
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        mysqli_close($connection);
    }
}





