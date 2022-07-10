<div id="mostrar-oficina">
    <div class="box-ow ofic-card row g-0">
        
        <div class="ofic-card-info col-md-4 col-sm-12">
            <i class="zmdi zmdi-assignment zmdi-hc-4x mb-3"></i>
            <h6 class="mb-3"><?= $this->data['nombre'] ?></h6>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, quisquam?</p>
            <button class="btn-ow btn-ow-orange">Editar</button>
        </div>

        <div class="ofic-card-cargo col-md-4 col-sm-6">
            <span>CARGOS</span>
        </div>

        <div class="ofic-card-oficina col-md-4 col-sm-6">
            <span><?= $this->tipoOficina ?></span>
            
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