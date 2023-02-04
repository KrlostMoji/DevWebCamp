<h1 class="dashboard__heading"><?php echo $titulo ?></h1>

<main class="bloques">
    <div class="bloques__grid">
        <div class="bloque">
            <h3 class="bloque__heading">Últimos registros</h3>
            <?php foreach($registros as $registro){ ?>
                <div class="bloque__contenido">
                    <p class="bloque__texto">
                        <?php echo $registro->usuario->nombre . " " . $registro->usuario->apellido ?>

                    </p>
                    <p class="bloque__plan">
                        <?php echo $registro->paquete->nombre; ?>

                    </p>

                </div>

            <?php } ?>
        </div>
        <div class="bloque">
            <h3 class="bloque__heading">Ingresos obtenidos</h3>
                <div class="bloque__contenido">
                    <p class="bloque__texto--ingresos">
                        <?php echo '$ '. $ingresos; ?>

                    </p>

                </div>

        </div>
        <div class="bloque">
            <h3 class="bloque__heading">Eventos con más demanda</h3>
                <?php foreach($menor_disponibilidad as $evento){ ?>
                <div class="bloque__contenido">
                    <p class="bloque__texto--cursos">
                        <?php echo $evento->nombre . " - " . $evento->disponibles . " Lugares" ?>

                    </p>

                </div>
                <?php } ?>
        </div>
        <div class="bloque">
            <h3 class="bloque__heading">Eventos con menos demanda</h3>
                <?php foreach($mayor_disponibilidad as $evento){ ?>
                <div class="bloque__contenido">
                    <p class="bloque__texto--cursos">
                        <?php echo $evento->nombre . " - " . $evento->disponibles . " Lugares" ?>

                    </p>

                </div>
                <?php } ?>
        </div>

    </div>

</main>