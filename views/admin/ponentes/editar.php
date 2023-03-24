<h1 class="dashboard__heading"><?php echo $titulo ?></h1>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/ponentes">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Regresar
    </a>
</div>

<div class="dashboard__formulario">
    <?php 
        include_once __DIR__ . '../../../templates/alertas.php';
    ?>
    <form class="formulario" method="POST" action="/admin/ponentes/editar<?php if($id){ echo '?id='.$id; }?>" enctype="multipart/form-data">
        <?php include_once __DIR__ . '/formulario.php' ?>
        <input class="formulario__submit formulario__submit--registrar" type="submit" value="Actualizar datos">
    </form>
</div>