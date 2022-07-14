<div id="crear-oficina">
	<div class="box-ow">
		<h6 class="box-ow-title weigth-500-ow col-md-7 col-sm-10">Nueva oficina</h6>
		
		<form id="form-oficina" class="box-ow-body col-md-7 col-sm-10" autocomplete="off" action="<?=URL_BASE?>oficina/createorupdate&operation=new" method="POST">
			<div class="form-field-ow">		<!-- Field NOMBRE -->
				<label for="nombre" class="weigth-500-ow">Nombre</label>
				<input class="input-ow" type="text" name="nombre" maxlength="100" pattern="\s*([A-Za-zÀ-ÿ]+\s*)+" required autofocus>
			</div>
			
			<fieldset class="form-field-ow">
				<legend class="weigth-500-ow">Selecciona el tipo de oficina</legend>
				<div>
					<input type="radio" name="tipo-oficina" id="oficinajefe" value="oficina-jefe" checked required>
					<label for="tipo-oficina">Oficina jefe</label>
				</div>
				<div>
					<input type="radio" name="tipo-oficina" id="suboficina" value="suboficina" required>
					<label for="tipo-oficina">Suboficina</label>
				</div>
			</fieldset>

			<div class="form-field-ow">		<!-- Field OFICINA-JEFE -->
				<label for="oficina-jefe" class="weigth-500-ow">Oficina jefe</label><br>
				<select name="oficina-jefe" class="input-ow"></select>
			</div>
			
			<div>
				<button type="submit" class="btn-ow btn-ow-blue">Crear</button>
			</div>
		</form>
    </div>
</div>