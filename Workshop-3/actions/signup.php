<?php
require '../utils/functions.php';

// comprueba que el request si o si lleve un firstname con el 'isset'para evitar que se ejecute sin datos.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['firstName'])) {
  //get each field and insert to the database
  $user['firstName'] = $_REQUEST['firstName'];
  $user['lastName'] = $_REQUEST['lastName'];
  $user['email'] = $_REQUEST['email'];
  $user['province_id'] = $_REQUEST['province'];
  $user['password'] = $_REQUEST['password'];

  if (saveUser($user)) {
    header("Location: /users.php");
  } else {
    header("Location: /?error=Invalid user data");
    exit();
  }
} else {
  header("Location: /?error=No data provided");
  exit();
}
