<div id="mostrar-cargo">
    <div class="box-ow">
        <h6 class="box-ow-title">Detalles del cargo</h6>
        <div class="details box-ow-body">
            <div class="row g-0">
                <span class="bold-ow col-sm-4">Nombre</span>
                <span class="col-sm-6"><?= $this->data['nombre']; ?></span>
            </div>

            <div class="row g-0">
                <span class="bold-ow col-sm-4">Nro de plaza</span>
                <span class="col-sm-6"><?= $this->data['nro_plaza']; ?></span>
            </div>

            <div class="row g-0">
                <span class="bold-ow col-sm-4">Código</span>
                <span class="col-sm-6"><?= $this->data['codigo']; ?></span>
            </div>

            <div class="row g-0">
                <span class="bold-ow col-sm-4">Clasificación</span>
                <span class="col-sm-6"><?= $this->data['clasificacion']; ?></span>
            </div>

            <div class="row g-0">
                <span class="bold-ow col-sm-4">Oficina</span>
                <span class="col-sm-6">
                    <a href="<?= URL_BASE ?>oficina/details&id=<?= $this->data['oficina_id'] ?>">
                    <?= $this->data['oficina']; ?></a>
                </span>
            </div>
            
            <div class="row g-0">
                <span class="bold-ow col-sm-4">Trabajador actual</span>
                <span class="col-sm-6" style="color: red">
                    <a href="#">Not implemented yet</a>
                </span>
            </div>

            <div class="main-cargo-data">
                <div class="row g-0">
                    <span class="bold-ow col-sm-4">Situación del cargo</span>
                    <span class="col-sm-6"><?= $this->data['situacion']; ?></span>
                </div>
    
                <div class="row g-0">
                    <span class="bold-ow col-sm-4">Observaciones</span>
                    <span class="col-sm-6"><?= $this->data['observacion']; ?></span>
                </div>

                <button class="btn-ow btn-ow-orange">Editar</button>
            </div>

            <div class="historial-cambios">
                <button class="btn-collapse">
                    <span>Historial de cambios</span>
                    <i class="zmdi zmdi-plus-circle"></i>
                </button>
                <div class="container-historial-cambio">

                    <button class="add btn-ow">
                        Nuevo
                    </button>

                    <?php require_once 'add-changes.php'; ?>

                    <table class="datatable-ow" id="datatable-historial-cambio">
                        <thead>
                            <tr>
                                <th>Nro Plaza</th>
                                <th>Nombre</th>
                                <th>Codigo</th>
                                <th>Clasif.</th>
                                <th>Oficina</th>
                                <th>Ordenanza</th>
                                <th>Fecha ordenanza</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($this->data_historial_cambio as $row): ?>
                            <tr data-id="<?=$row['id']?>" data-oficina-jefe="<?=$row['oficina_jefe']?>">
                                <td id="nro_plaza"><?= $row['nro_plaza'] ?></td>
                                <td id="nombre"><?= $row['nombre'] ?></td>
                                <td id="codigo"><?= $row['codigo'] ?></td>
                                <td id="clasificacion"><?= $row['clasificacion'] ?></td>
                                <td id="oficina_id" data-oficina-id="<?=$row['oficina_id']?>"><?= $row['oficina'] ?></td>
                                <td id="ordenanza"><?= $row['ordenanza'] ?></td>
                                <td id="fecha_ordenanza"><?= $row['fecha_ordenanza'] ?></td>
                                <td id="actions" class="actions">
                                    <div>
                                        <button class="editBtn btn-ow btn-ow-purple" title="editar" data-bs-toggle="modal" data-bs-target="#editar-cargo-modal">
                                            <i class="zmdi zmdi-edit"></i>
                                        </button>
                                        <button class="deleteBtn btn-ow btn-ow-red" title="eliminar"><i class="zmdi zmdi-delete"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
    <?php require_once 'edit-changes.php'; ?>
</div>