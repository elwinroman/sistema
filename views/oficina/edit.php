<!-- Modal -->
<div id="editar-oficina-modal" class="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Modal title</h6>
                <button type="button" class="close btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-oficina" autocomplete="off" action="<?=URL_BASE?>oficina/update&id=<?=$this->data['id']?>" method="POST">
                    <div class="form-field-ow">		<!-- Field NOMBRE -->
                        <label for="nombre" class="bold-ow">Nombre</label>
                        <input class="input-ow input-height-ow" type="text" name="nombre" maxlength="60" value="<?= $this->data['nombre'] ?>" pattern="\s*([A-Za-zÀ-ÿ,.-]+\s*)+" required autofocus>
                    </div>
                    
                    <fieldset class="form-field-ow">
                        <legend class="bold-ow">Selecciona el tipo de oficina</legend>
                        <div>
                            <?php if(is_null($this->data['oficina_id'])): ?>
                                <input type="radio" name="tipo-oficina" id="oficinajefe" value="oficina-jefe" checked required>
                            <?php else: ?>
                                <input type="radio" name="tipo-oficina" id="oficinajefe" value="oficina-jefe" required>
                            <?php endif; ?>
                            <label for="tipo-oficina">Órgano</label>
                        </div>
                        
                        <div>
                            <?php if(is_null($this->data['oficina_id'])): ?>
                                <input type="radio" name="tipo-oficina" id="suboficina" value="suboficina" required>
                            <?php else: ?>
                                <input type="radio" name="tipo-oficina" id="suboficina" value="suboficina" checked required>
                            <?php endif; ?>
                            <label for="tipo-oficina">Unidad orgánica</label>
                        </div>
                    </fieldset>

                    <div class="form-field-ow">		<!-- Field OFICINA-JEFE -->
                        <label for="oficina-jefe" class="bold-ow">Órgano</label><br>
                        <select name="oficina-jefe" class="input-ow input-height-ow" data-selected="<?= $this->data['oficina_id'] ?>"></select>
                    </div>

                    <div class="form-field-ow">
                            <label for="observacion" class="bold-ow">Observación</label><br>
                            <textarea class="input-ow" name="observacion" rows="5" maxlength="200"><?= $this->data['observacion'] ?></textarea>
                    </div>

                    <div>
                        <button type="submit" class="btn-ow btn-ow-blue">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>