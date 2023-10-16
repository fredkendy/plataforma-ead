<?php

if(!function_exists('protect')) {

    function protect($admin) {
        
        //Inicia a sessão
        if (!isset($_SESSION)) { 
            session_start();
        }
        
        //Se não existir a id, redireciona para o login
        if (!isset($_SESSION['usuario'])) {
            die("<script>location.href='login.php';</script>");
        }

        if ($admin == 1 && $_SESSION['admin'] != 1) {
            die("<script>location.href='login.php';</script>");
        }
    }

}