<!-- Modal -->
<div class="modal" id="editar-oficina-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Modal title</h5>
                <button type="button" class="close" data-bs-dismiss="modal">x</button>
            </div>
            <div class="modal-body">
                <form id="form-oficina" autocomplete="off" action="<?=URL_BASE?>oficina/editar" method="POST">
                    <h6 class="">Datos de la oficina</h6>
                    <div class="form-field-ow">		<!-- Field NOMBRE -->
                        <label for="nombre" class="weigth-500-ow">Nombre</label>
                        <input class="input-ow" type="text" name="nombre" maxlength="100" value="<?= $this->data['nombre'] ?>" pattern="\s*([A-Za-zÀ-ÿ]+\s*)+" required autofocus>
                    </div>
                    
                    <fieldset class="form-field-ow">
                        <legend class="weigth-500-ow">Selecciona el tipo de oficina</legend>

                        <?php if(is_null($this->data['oficina_id'])): ?>
                            <input type="radio" name="tipo-oficina" id="oficinajefe" value="oficina-jefe" checked required>
                        <?php else: ?>
                            <input type="radio" name="tipo-oficina" id="oficinajefe" value="oficina-jefe" required>
                        <?php endif; ?>
                        <label for="tipo-oficina">Oficina jefe</label>
                        
                        <?php if(is_null($this->data['oficina_id'])): ?>
                            <input type="radio" name="tipo-oficina" id="suboficina" value="suboficina" required>
                        <?php else: ?>
                            <input type="radio" name="tipo-oficina" id="suboficina" value="suboficina" checked required>
                        <?php endif; ?>
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
    </div>
</div>