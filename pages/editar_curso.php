<?php

    include("lib/conexao.php");
    include("lib/enviar_arquivo.php");

    //Somente admin (1) tem acesso a essa página
    include('lib/protect.php');
    protect(1);

    // Pegar o id do curso para fazer o autocomplete dos campos
    $id = intval($_GET['id']); 

    if (isset($_POST['enviar'])) {
        
        //escape_string para evitar SQL Injection
        $titulo = $mysqli->escape_string($_POST['titulo']); 
        $descricao_curta = $mysqli->escape_string($_POST['descricao_curta']);
        $preco = $mysqli->escape_string($_POST['preco']);
        $conteudo = $mysqli->escape_string($_POST['conteudo']); 
        
        $erro = array();
        if (empty($titulo)) {
            $erro[] = "Preencha o campo título";
        }
        if (empty($descricao_curta)) {
            $erro[] = "Preencha o campo descrição curta";
        }
        if (empty($preco)) {
            $erro[] = "Preencha o campo preço";
        }
        if (empty($conteudo)) {
            $erro[] = "Preencha o campo conteúdo";
        }

        if (count($erro) == 0) {
            $imagemAlterada = false;

            if(isset($_FILES['imagem']) && isset($_FILES['imagem']['size']) && $_FILES['imagem']['size'] > 0) {
                //Esta função receberá o caminho do arquivo
                $deu_certo = enviarArquivo($_FILES['imagem']['error'], $_FILES['imagem']['size'], $_FILES['imagem']['name'], $_FILES['imagem']['tmp_name']);
                $imagemAlterada = true;
            } else {
                $deu_certo = true;
            }
        
        if ($deu_certo !== false) {

            if ($imagemAlterada) {
                $sql_code = "UPDATE cursos SET
                    titulo = '$titulo',
                    descricao_curta = '$descricao_curta',
                    conteudo = '$conteudo',
                    preco = '$preco',
                    imagem = '$deu_certo'
                WHERE id = '$id'
                ";
            } else {
                $sql_code = "UPDATE cursos SET
                    titulo = '$titulo',
                    descricao_curta = '$descricao_curta',
                    conteudo = '$conteudo',
                    preco = '$preco'
                WHERE id = '$id'
                ";
            }

            $inserido = $mysqli->query($sql_code) or die($mysqli->error);

            if (!$inserido) {
                $erro[] = "Falha ao cadastrar curso " . $mysqli->error;
            } else {
                die("<script>location.href='index.php?p=gerenciar_cursos';</script>");
            }

        } else {
            $erro[] = "Falha ao enviar o arquivo";
        }

    }
}

// Pegar o id do curso para fazer o autocomplete dos campos
$sql_query = $mysqli->query("SELECT * FROM cursos WHERE id = '$id'") or die($mysqli->error);
$curso = $sql_query->fetch_assoc();

?>


<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-6">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Cadastrar Curso</h4>
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
                        <a href="index.php?p=gerenciar_cursos">
                            Gerenciar Curso
                        </a>
                    </li>
                    <li class="breadcrumb-item">Cadastrar Curso</a>
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

            <div class="alert alert-danger" role="alert">
                This is a danger alert-check!
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Formulário de Cadastro</h5>
                </div>

                <div class="card-block">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Título</label>
                                    <input type="text" value="<?php echo $curso['titulo']; ?>" name="titulo" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="">Descrição curta</label>
                                    <input type="text" value="<?php echo $curso['descricao_curta']; ?>" name="descricao_curta" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="">Imagem</label>
                                    <input type="file" name="imagem" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Preço</label>
                                    <input type="text" value="<?php echo $curso['preco']; ?>" name="preco" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Conteúdo</label>
                                    <textarea name="conteudo" rows="6" class="form-control"><?php echo $curso['conteudo']; ?>"</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <!-- JS para incluir href no botão, ou mudar de 'button' para 'a' -->
                                <button type="button" onClick="location.href='index.php?p=gerenciar_cursos'" class="btn btn-primary btn-round"><i class="ti-arrow-left"></i> Voltar</button>
                                <button type="submit" name="enviar" value="1" class="btn btn-success btn-round float-right"><i class="ti-save"></i> Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>

                

                
            </div>
        </div>
    </div>
</div>