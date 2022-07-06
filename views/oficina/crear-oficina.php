<div id="crear-oficina">
	<h1 class="weigth-500-ow">Crear oficina</h1>
    <div class="box-ow">
        <form id="form-oficina" autocomplete="off" action="<?=URL_BASE?>oficina/crear" method="POST">
			<h6 class="">Datos de la oficina</h6>
			<div class="form-field-ow">		<!-- Field NOMBRE -->
				<label for="nombre" class="weigth-500-ow">Nombre</label>
				<input class="input-ow" type="text" name="nombre" maxlength="100" pattern="\s*([A-Za-zÀ-ÿ]+\s*)+" required autofocus>
			</div>
			
			<fieldset class="form-field-ow">
				<legend class="weigth-500-ow">Selecciona el tipo de oficina</legend>
				<input type="radio" name="tipo-oficina" id="oficinajefe" value="oficina-jefe" checked required>
				<label for="tipo-oficina">Oficina jefe</label>
				<input type="radio" name="tipo-oficina" id="suboficina" value="suboficina" required>
				<label for="tipo-oficina">Suboficina</label>
			</fieldset>

			<div class="form-field-ow">		<!-- Field OFICINA-JEFE -->
				<label for="oficina-jefe" class="weigth-500-ow">Oficina jefe</label><br>
				<select name="oficina-jefe" class="input-ow"></select>
			</div>
			<div>
				<button type="submit" class="btn-ow btn-ow-primary">Guardar</button>
			</div>
		</form>
    </div>
</div>