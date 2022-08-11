<!-- Modal -->
<div id="editar-cargo-modal" class="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Modal title</h6>
                <button type="button" class="close btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="form-cargo" class="form-add" autocomplete="on" action="<?=URL_BASE?>cargo/addorupdatechanges&op=update&id-main=<?=$_GET['id']?>&id=" method="POST">
                    <div class="row g-0 gap-ow-15">
                        <div class="datos-cargo col-md-6">
                            
                            <!-- Campo nombre -->
                            <div class="form-field-ow">
                                <label for="nombre" class="bold-ow">Nombre</label>
                                <input class="input-ow input-height-ow" type="text" name="nombre" pattern="\s*([A-Za-zÀ-ÿ,.-]\s*)+" maxlength="60" required autofocus>
                            </div>

                            <div class="row g-0 gap-ow-5">
                                <!-- Campo nro_plaza -->
                                <div class="form-field-ow col">
                                    <label for="nro-plaza" class="bold-ow">Nro plaza</label>
                                    <input class="input-ow input-height-ow" type="text" name="nro-plaza" pattern="\s*[0-9]{3}\s*" maxlength="6" required>
                                </div>

                                <!-- Campo clasificacion -->
                                <div class="form-field-ow col">
                                    <label for="clasificacion" class="bold-ow">Clasificacion</label>
                                    <input class="input-ow input-height-ow" type="text" name="clasificacion" pattern="\s*[A-Za-z-]+\s*" maxlength="8" required>
                                </div>
                            </div>

                            <!-- Campo codigo -->
                            <div class="form-field-ow col">
                                <label for="codigo" class="bold-ow">Código</label>
                                <input class="input-ow input-height-ow" type="text" name="codigo" pattern="\s*[0-9]+\s*" maxlength="10">
                            </div>

                            <!-- Campo ordenanza -->
                            <div class="form-field-ow">
                                <label for="ordenanza" class="bold-ow">Ordenanza</label>
                                <input class="input-ow input-height-ow" type="text" name="ordenanza" pattern="\s*([A-Za-zÀ-ÿ0-9,;(){}[\]*+¿?!¡:._-]\s*)+" maxlength="50" required>
                            </div>

                            <div class="form-field-ow" style="width: 50%">
                                <label for="fecha-ordenanza">Fecha de ordenanza</label>
                                <input class="input-ow input-height-ow" name="fecha-ordenanza" type="date" required>
                            </div>

                        </div>

                        <div class="col-md-6">
                            
                            <!-- Campo oficina-jefe -->
                            <div class="form-field-ow">
                                <label for="oficina-jefe" class="bold-ow">Órgano</label><br>
                                <select name="oficina-jefe" class="input-ow input-height-ow" required></select>
                            </div>

                            <div class="form-field-ow">
                                <input type="checkbox" class="form-check-input" name="checkbox" value="active">
                                <label for="checkbox" class="">Habilitar Suboficinas</label>
                            </div>

                            <!-- Campo suboficina -->
                            <div class="form-field-ow">
                                <label for="suboficina" class="bold-ow">Unidad orgánica</label><br>
                                <select name="suboficina" class="input-ow input-height-ow" disabled="true"></select>
                            </div>

                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn-ow btn-ow-blue">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>