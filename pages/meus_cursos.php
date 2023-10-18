<?php

include('lib/protect.php');
protect(0);

if (!isset($_SESSION)) {
    session_start();
}

$id_usuario = $_SESSION['usuario'];
$cursos_query = $mysqli->query("SELECT * FROM cursos WHERE id IN (SELECT id_curso FROM relatorio WHERE id_usuario = '$id_usuario')") or die($mysqli->error);

?>


<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Meus Cursos</h4>
                    <span>Veja a lista dos cursos que você adquiriu</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.php">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">Meus Cursos</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Page-header end -->

<div class="page-body">
    <div class="row">

    <?php while ($curso = $cursos_query->fetch_assoc()) { ?>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo $curso['titulo']; ?></h5>
                </div>
                <div class="card-block">
                    <img class="img-fluid mb-3" src="<?php echo $curso['imagem']; ?>">
                    <p>
                        <?php echo $curso['descricao_curta']; ?>
                    </p>
                    <form action="index.php">
                        <!-- value se refere ao nome da página assistir.php --> 
                        <input type="hidden" name="p" value="assistir">
                        <input type="hidden" name="id" value="<?php echo $curso['id']; ?>">
                        <button type="submit" class="btn form-control btn-primary">Acessar</button> 
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>

    </div>
</div>