<?php

    include("lib/conexao.php");
    include("lib/enviar_arquivo.php");

    if (isset($_POST['enviar'])) {
        
        //escape_string para evitar SQL Injection
        $nome = $mysqli->escape_string($_POST['nome']); 
        $email = $mysqli->escape_string($_POST['email']);
        $creditos = $mysqli->escape_string($_POST['creditos']);
        $senha = $mysqli->escape_string($_POST['senha']); 
        $rsenha = $mysqli->escape_string($_POST['rsenha']); 
        
        $erro = array();
        if (empty($nome)) {
            $erro[] = "Preencha o campo nome";
        }
        if (empty($email)) {
            $erro[] = "Preencha o campo email";
        }
        if (empty($creditos)) {
            $creditos = 0;
        }
        if (empty($senha)) {
            $erro[] = "Preencha o campo senha";
        }
        if ($rsenha != $senha) {
            $erro[] = "Senha e confirmação de senha não conferem";
        }

        if (count($erro) == 0) {

            //Criptografar a senha
            $senha = password_hash($senha, PASSWORD_DEFAULT);

            $mysqli->query("INSERT INTO usuarios (nome, email, senha, data_cadastro, creditos) VALUES (
                '$nome',
                '$email',
                '$senha',
                NOW(),
                '$creditos'
            )");
            die("<script>location.href='index.php?p=gerenciar_usuarios';</script>");
        }
    }


?>


<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-6">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Cadastrar Usuário</h4>
                    <span>Preencha as informações e clique em salvar</span>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.php">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="index.php?p=gerenciar_usuarios">
                            Gerenciar Usuário
                        </a>
                    </li>
                    <li class="breadcrumb-item">Cadastrar Usuário</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Page-header end -->

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">

            <?php if (isset($erro) && count($erro) > 0) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php  
                        foreach ($erro as $msg) {
                            echo "<p> $msg </p>";
                        }
                    ?>
                </div>
            <?php } ?>

            <div class="card">
                <div class="card-header">
                    <h5>Formulário de Cadastro</h5>
                </div>

                <div class="card-block">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Nome</label>
                                    <input type="text" name="nome" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Créditos</label>
                                    <input type="text" name="creditos" class="form-control">
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Senha</label>
                                    <input type="password" name="senha" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Repita a senha</label>
                                    <input type="password" name="rsenha" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <!-- JS para incluir href no botão, ou mudar de 'button' para 'a' -->
                                <button type="button" onClick="location.href='index.php?p=gerenciar_usuarios'" class="btn btn-primary btn-round"><i class="ti-arrow-left"></i> Voltar</button>
                                <button type="submit" name="enviar" value="1" class="btn btn-success btn-round float-right"><i class="ti-save"></i> Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>