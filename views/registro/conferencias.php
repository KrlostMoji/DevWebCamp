
<h2 class="pagina__heading"><?php echo $titulo; ?></h2>
<p class="pagina__descripcion">Elige hasta 5 eventos a los cuales deseas asistir de forma presencial</p>

<div class="eventos-registros">
    <main class="eventos-registros__listado">
        <h3 class="eventos-registros__heading--conferencias">&lt;Conferencias</h3>

        <p class="eventos-registros__fecha">Viernes 5 de Octubre</p>

        <div class="eventos-registros__grid eventos--conferencias">
            <?php foreach($eventos['conferencias_v'] as $evento){ ?>
                <?php include __DIR__ . '../../registro/evento.php' ?>
            <?php } ?>

        </div>

        <p class="eventos-registros__fecha">Sábado 6 de octubre</p>

        <div class="eventos-registros__grid eventos--conferencias">
            <?php foreach($eventos['conferencias_s'] as $evento){ ?>
                <?php include __DIR__ . '../../registro/evento.php' ?>
            <?php } ?>

        </div>

        <h3 class="eventos-registros__heading--workshops">&lt;Workshops</h3>

        <p class="eventos-registros__fecha">Viernes 5 de Octubre</p>

        <div class="eventos-registros__grid eventos--workshops">
            <?php foreach($eventos['workshops_v'] as $evento){ ?>
                <?php include __DIR__ . '../../registro/evento.php' ?>
            <?php } ?>

        </div>

        <p class="eventos-registros__fecha">Sábado 6 de octubre</p>

        <div class="eventos-registros__grid eventos--workshops">
            <?php foreach($eventos['workshops_s'] as $evento){ ?>
                <?php include __DIR__ . '../../registro/evento.php' ?>
            <?php } ?>

        </div>

    </main>

    <aside class="registro">
                <h2 class="registro__heading">Tu registro</h2>
                <div id="registro-resumen" class="registro-resumen"></div>

                <div class="registro__regalo">
                    <label for="regalo" class="registro__label">Selecciona un regalo</label>
                    <select class="registro__select" id="regalo">
                        <option value=""><--Selecciona--></option>
                        <?php foreach($regalos as $regalo) { ?>
                            <option value="<?php echo $regalo->id; ?>"><?php echo $regalo->nombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <form id="registro" class="formulario">
                    <div class="formulario__campo">
                        <input type="submit" class="formulario__submit formulario__submit--full" value="Completar registro">
                    </div>
                </form>

    </aside>

</div>
