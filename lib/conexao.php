<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "plataforma_ead";

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_errno) {
    echo "Falha na conexão: " . $mysqli->connect_error;
    exit();
}