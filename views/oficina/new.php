<div id="crear-oficina">
	<div class="box-ow">
		<h6 class="box-ow-title bold-ow col-md-7 col-sm-10">Nueva oficina</h6>
		
		<form id="form-oficina" class="box-ow-body col-md-7 col-sm-10" autocomplete="off" action="<?=URL_BASE?>oficina/create" method="POST">
			<div class="form-field-ow">		<!-- Field NOMBRE -->
				<label for="nombre" class="bold-ow">Nombre</label>
				<input class="input-ow input-height-ow" type="text" name="nombre" maxlength="60" pattern="\s*([A-Za-zÀ-ÿ,.-]+\s*)+" required autofocus>
			</div>
			
			<fieldset class="form-field-ow">
				<legend class="bold-ow">Selecciona el tipo de oficina</legend>
				<div>
					<input type="radio" name="tipo-oficina" id="oficinajefe" value="oficina-jefe" checked required>
					<label for="tipo-oficina">Órgano</label>
				</div>
				<div>
					<input type="radio" name="tipo-oficina" id="suboficina" value="suboficina" required>
					<label for="tipo-oficina">Unidad orgánica</label>
				</div>
			</fieldset>

			<div class="form-field-ow">		<!-- Field OFICINA-JEFE -->
				<label for="oficina-jefe" class="bold-ow">Órgano</label><br>
				<select name="oficina-jefe" class="input-ow input-height-ow"></select>
			</div>
			
			<div>
				<button type="submit" class="btn-ow btn-ow-blue">Crear</button>
			</div>
		</form>
    </div>
</div>