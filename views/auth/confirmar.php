<main class="auth">
    <h2 class="auth__heading">
        <?php echo $titulo; ?>
    </h2>
    <p class="auth__texto">
        Bienvenido a DevWebCamp. 
    </p>
    <?php 
        require_once __DIR__.'/../templates/alertas.php';
    ?>
    <div class="acciones--centrar">
    <?php if(isset($alertas['exito'])){ ?>
        <a href="/login" class="acciones__enlace">
            Iniciar Sesión
        </a>
    <?php
    } else{ ?>
        <a href="/registro" class="acciones__enlace">
            Crear una cuenta
        </a>
    <?php } ?>
        
    </div>
</main>