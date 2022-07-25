<div id="mostrar-oficina">
    <div class="box-ow ofic-card row g-0">
        
        <div class="ofic-card-info col-md-4 col-sm-12">
            <i class="zmdi zmdi-assignment zmdi-hc-4x mb-3"></i>
            <h6 class="mb-3" id="oficina-name-id" data-id=<?= $this->data['id']?> ><?= $this->data['nombre'] ?></h6>
            <p><?=$this->data['observacion']?></p>
            
            <!-- Button activador modal editar oficina -->
            <button class="btn-ow btn-ow-orange" data-bs-toggle="modal" data-bs-target="#editar-oficina-modal">
                Editar
            </button>
        </div>

        <div class="ofic-card-cargo col-md-4 col-sm-6">
            <span class="ofic-card-title bold-ow">CARGOS</span>
            <?php if(is_array($this->cargos)): ?>
                <ul>
                    <?php foreach($this->cargos as $cargo): ?>
                        <li><?= $cargo['nombre'] ?></li>
                    <?php endforeach; ?>
                </ul> 
            <?php else: ?>
                <li><?= $this->cargos ?></li>
            <?php endif; ?>
        </div>

        <div class="ofic-card-oficina col-md-4 col-sm-6">
            <span class="ofic-card-title bold-ow"><?= $this->tipoOficina ?></span>
            
            <?php if(is_array($this->oficina)): ?>
                <ul>
                    <?php foreach($this->oficina as $of): ?>
                        <li><?= $of['nombre'] ?></li>
                    <?php endforeach; ?>
                </ul> 
            <?php else: ?>
                <li><?= $this->oficina ?></li>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require 'edit.php'; ?>