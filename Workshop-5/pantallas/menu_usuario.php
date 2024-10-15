<?php

session_start();

$email_usuario = $_SESSION['email'];

$timestamp = time();
$currentDate = gmdate('d-m-Y H:i:s', $timestamp);

echo "<p><b>".$email_usuario."</b><p> <p>Fecha login: </p>". $currentDate;