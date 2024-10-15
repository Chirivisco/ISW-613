<?php

function getConnection(): bool|mysqli
{
  $connection = mysqli_connect('localhost', 'root', '', 'isw613-Clase04');
  print_r(mysqli_connect_error());
  return $connection;
}

// Función para iniciar una nueva sesión con un usuario
function login($user)
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
                        // Inicia una sesión
                        session_start();
                        $_SESSION["email"] = $username;
                        $_SESSION["tipo"] = $tipo_usuario;

                        // Retorna true y su rol de usuario
                        return ['success' => true, 'tipo' => $tipo_usuario];
                    } else {
                        // Retorna false y null si la autenticación falló
                        return ['success' => false, 'tipo' => null];
                    }
                } else {
                    // Retorna false y null si no hay registros o resultados del query
                    return ['success' => false, 'tipo' => null];
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
}

// Función para obtener el ID de un usuario basado en su email
function getIdByUser($email) {
    // Obtiene la conexión a la base de datos
    $connection = getConnection();

    $query = "SELECT ID FROM USERS WHERE USERNAME = ? LIMIT 1";

    try {
        // Prepara la consulta SQL
        $stmt = $connection->prepare($query);
        if (!$stmt) {
            throw new Exception("Error en la consulta SQL: " . $connection->error);
        } else {
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    return $row['ID'];
                } else {
                    return null;
                }
            } else {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        $connection->close();
    }
}

// Función para registrar la fecha y hora del login
function setLoginDateTime($user_id, $datetime): bool {
    // Obtiene la conexión a la base de datos
    $connection = getConnection();

    // Corrige la consulta SQL: usa una coma para separar los campos a actualizar
    $query = "UPDATE USERS SET FECHA_LOGIN = ?, STATUS = 'A' WHERE ID = ?;";

    try {
        $stmt = $connection->prepare($query);
        if (!$stmt) {
            throw new Exception("Error en la consulta SQL: " . $connection->error);
        } else {
            // Se usan los mismos tipos: fecha como string y ID como entero
            $stmt->bind_param("si", $datetime, $user_id);
            if (!$stmt->execute()) {
                throw new Exception("Error al actualizar la fecha de login: " . $stmt->error);
                return false;
            } else {
                return true;
            }
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;  // Devuelve false en caso de error
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        $connection->close();
    }
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





