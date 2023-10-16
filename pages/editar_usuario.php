<?php

    include("lib/conexao.php");
    include("lib/enviar_arquivo.php");

    //Somente admin (1) tem acesso a essa página
    include('lib/protect.php');
    protect(1);

    $id = intval($_GET['id']);

    if (isset($_POST['enviar'])) {
        
        //escape_string para evitar SQL Injection
        $nome = $mysqli->escape_string($_POST['nome']); 
        $email = $mysqli->escape_string($_POST['email']);
        $creditos = $mysqli->escape_string($_POST['creditos']);
        $senha = $mysqli->escape_string($_POST['senha']); 
        $rsenha = $mysqli->escape_string($_POST['rsenha']); 
        $admin = $mysqli->escape_string($_POST['admin']);
        
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
        if ($rsenha != $senha) {
            $erro[] = "Senha e confirmação de senha não conferem";
        }

        if (count($erro) == 0) {

            $sql_code = "UPDATE usuarios SET 
                nome = '$nome',
                email = '$email',
                creditos = '$creditos',
                admin = '$admin'
            WHERE id = '$id'";

            if(!empty($senha)) {
                //Criptografar a senha caso seja alterada
                $senha = password_hash($senha, PASSWORD_DEFAULT);
                
                $sql_code = "UPDATE usuarios SET 
                nome = '$nome',
                email = '$email',
                senha = '$senha',
                creditos = '$creditos',
                admin = '$admin'
            WHERE id = '$id'";
            }

            $mysqli->query($sql_code) or die($mysqli->error);
            die("<script>location.href='index.php?p=gerenciar_usuarios';</script>");
        }
    }

//Puxando informações do banco de dados
$sql_query = $mysqli->query("SELECT * FROM usuarios WHERE id = '$id'") or die($mysqli->error);
$usuario = $sql_query->fetch_assoc();


?>


<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-6">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Editar Usuário</h4>
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
                    <li class="breadcrumb-item">Editar Usuário</a>
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
                    <h5>Formulário de Edição de Usuário</h5>
                </div>

                <div class="card-block">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Nome</label>
                                    <input type="text" value="<?php echo $usuario['nome'] ?>" name="nome" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" value="<?php echo $usuario['email'] ?>" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Créditos</label>
                                    <input type="text" value="<?php echo $usuario['creditos'] ?>" name="creditos" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Senha</label>
                                    <input type="password" name="senha" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Repita a senha</label>
                                    <input type="password" name="rsenha" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Tipo</label>
                                    <select name="admin" class="form-control">
                                        <option value="0">Usuário</option>
                                        <option <?php if($usuario['admin']) {echo 'selected';} ?> value="1">Admin</option>
                                    </select>
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