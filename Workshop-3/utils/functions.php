<?php

/**
 *  Gets the provinces from the database
 */
function getProvinces(): array {
  $select = "SELECT * FROM PROVINCES;";
  $provincias = [];
  try {
    $conn = getConnection();
    $result = mysqli_query($conn, $select);

    if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
        $provincias[$row['ID']] = $row['PROVINCE'];
      }
    }
    mysqli_close($conn);
  }
  catch(Exception $e) {
    echo $e->getMessage();
  }
  return $provincias;
}



function getConnection(): bool|mysqli {
  $connection = mysqli_connect('localhost', 'root', '', 'isw613-Clase03');
  print_r(mysqli_connect_error());
  return $connection;
}

/**
 * Saves an specific user into the database
 */
function saveUser($user): bool {
  $firstName = $user['firstName'];
  $lastName = $user['lastName'];
  $username = $user['email'];
  $password = md5($user['password']);
  $province_id = $user['province_id'];

  // Generar la consulta SQL
  $sql = "INSERT INTO USERS (NAME, LASTNAME, USERNAME, PASSWORD, PROVINCE) 
          VALUES('$firstName', '$lastName', '$username','$password', '$province_id')";

  try {
    $conn = getConnection();
    
    if (mysqli_query($conn, $sql)) {
      return true;
    } else {
      echo "Error al ejecutar la consulta: " . mysqli_error($conn);
      return false;
    }
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
}

function getUsers(): array {
  $users = [];
  $conn = getConnection();
  // Consulta que une usuarios con provincias
  $sql = "
      SELECT u.NAME AS nombre, u.LASTNAME AS apellido, u.USERNAME AS correo, p.PROVINCE AS provincia 
      FROM USERS u
      INNER JOIN PROVINCES p ON u.PROVINCE = p.ID
  ";
  $result = mysqli_query($conn, $sql);
  
  if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $users[] = $row; 
      }
  } else {
      $users = null;
  }

  mysqli_close($conn);
  return $users;
}
