<?php

include("lib/conexao.php");

//Somente admin (1) tem acesso a essa página
include('lib/protect.php');
protect(1);

$id = intval($_GET['id']);

$mysql_query = $mysqli->query("DELETE FROM usuarios WHERE id = '$id'") or die($mysqli->error);

die("<script>location.href='index.php?p=gerenciar_usuarios';</script>");