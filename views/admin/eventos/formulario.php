<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del Evento</legend>
    
    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre Evento</label>
        <input  
            type="text"
            class="formulario__input"
            id="nombre"
            name="nombre"
            placeholder="Nombre Evento"
            value="<?php echo $evento->nombre ?? ''; ?>"
                >
    </div>    
    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Descripción</label>
        <textarea 
            class="formulario__textarea"
            id="descripcion"
            name="descripcion"
            placeholder="Descripción del evento"
            rows="8"
        ><?php echo $evento->descripcion ?? ''; ?></textarea>
    </div>

    <div class="formulario__campo">
        <label for="categoria" class="formulario__label">Categoría del evento</label>
        <select 
            class="formulario__select"
            id="categoria"
            name="categoria_id">
            <option value=""><-Selecciona-></option>
            <?php foreach ($categorias as $categoria){ ?>
            <option <?php echo ($evento->categoria_id === $categoria->id) ? 'selected' : '' ?> value="<?php echo $categoria->id?>"><?php echo $categoria->nombre ?></option>
            <?php } ?>
        </select>
    </div>    

    <div class="formulario__campo">
        <label for="dia" class="formulario__label">Selecciona el día</label>
        <div class="formulario__radio">
            <?php foreach ($dias as $dia){ ?>
                <div>
                    <label for="<?php echo strtolower($dia->nombre); ?>"><?php echo $dia->nombre ?></label>
                    <input 
                        type="radio" 
                        id="<?php echo $dia->id?>"
                        name="dia"
                        value="<?php echo $dia->id?>"
                        <?php echo ($evento->dia_id === $dia->id) ? 'checked' : '' ?>
                    />
                </div>
            <?php } ?>
        </div>
        <input type="hidden" name="dia_id" value="<?php echo $evento->dia_id ?>">
    </div>    

    <div class="formulario__campo">
        <label class="formulario__label">Selecciona el horario</label>
        <ul class="horas" id="horas">
                <?php foreach ($horas as $hora) { ?>
                    <li data-hora-id="<?php echo $hora->id; ?>" class="horas__hora horas__hora--deshabilitada"><?php echo $hora->hora; ?></li>
                <?php } ?>
        </ul>

        <input type="hidden" name="hora_id" value="<?php echo $evento->hora_id ?>">
    </div> 

</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información adicional</legend>
        <div class="formulario__campo">
            <label for="ponentes" class="formulario__label">Ponente</label>
            <input 
                type="text"
                class="formulario__input"
                id="ponentes"
                name="ponentes"
                placeholder="Buscar..."
            >
            <ul class="listado-ponentes" id="listado-ponentes">

            </ul>
            <input type="hidden" name="ponente_id" value="<?php echo $evento->ponente_id ?>">
        </div>
        <div class="formulario__campo">
            <label for="disponibles" class="formulario__label">Lugares disponibles</label>
            <input 
                type="number"
                min="1"
                class="formulario__input"
                name="disponibles"
                id="disponibles"
                value="<?php echo $evento->disponibles; ?>"
                placeholder="Lugares disponibles"
            >
        </div>
</fieldset>