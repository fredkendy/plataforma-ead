<?php

include("lib/conexao.php");

//Somente admin (1) tem acesso a essa página
include('lib/protect.php');
protect(1);

$id = intval($_GET['id']);

$mysql_query = $mysqli->query("SELECT imagem FROM cursos WHERE id = '$id'") or die($mysqli->error);
$curso = $mysql_query->fetch_assoc();

if(unlink($curso['imagem'])) {
    $mysqli->query("DELETE FROM cursos WHERE id = '$id'") or die($mysqli->error);
}

die("<script>location.href='index.php?p=gerenciar_cursos';</script>");