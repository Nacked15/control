<?php

if(isset($this->_paginacion)): ?>
    <ul class="pagination text-center" role="navigation" aria-label="Pagination">
        <?php if($this->_paginacion['primero']): ?>
            <li>
                <a class="<?= $classpagination;?>" 
                   <?= $datattr;?>="<?php echo $this->_paginacion['primero']; ?>" 
                   href="javascript:void(0);">&Lt;</a>
            </li>
        <?php else: ?>
            <li class="pagination-previous disabled"><span>&Lt;</span></li>
        <?php endif; ?>


        <?php if($this->_paginacion['anterior']): ?>
            <li>
                <a  class="<?= $classpagination;?>" 
                    <?= $datattr;?>="<?php echo $this->_paginacion['anterior']; ?>" 
                    href="javascript:void(0);"><span>&lt;</span></a>
            </li>
        <?php else: ?>
            <li class="pagination-previous disabled"><span>&lt;</span></li>
        <?php endif; ?>


        <?php for($i = 0; $i < count($this->_paginacion['rango']); $i++): ?>

            <?php if($this->_paginacion['actual'] == $this->_paginacion['rango'][$i]): ?>
                <li class="active">
                    <span><?php echo $this->_paginacion['rango'][$i]; ?></span>
                </li>
            <?php else: ?>
                <li>
                    <a  class="<?= $classpagination;?>" 
                        <?= $datattr;?>="<?php echo $this->_paginacion['rango'][$i]; ?>" 
                        href="javascript:void(0);">
                        <?php echo $this->_paginacion['rango'][$i]; ?>
                    </a>
                </li>
            <?php endif; ?>

        <?php endfor; ?>


        <?php if($this->_paginacion['siguiente']): ?>

            <li>
                <a  class="<?= $classpagination;?>" 
                    <?= $datattr;?>="<?php echo $this->_paginacion['siguiente']; ?>" 
                    href="javascript:void(0);"<span>&gt;</span></a>
            </li>

        <?php else: ?>
            <li class="pagination-next disabled"><span>&gt;</span></li>
        <?php endif; ?>


        <?php if($this->_paginacion['ultimo']): ?>

            <li>
                <a  class="<?= $classpagination;?>" 
                    <?= $datattr; ?>="<?php echo $this->_paginacion['ultimo']; ?>" 
                    href="javascript:void(0);">&Gt;</a>
            </li>

        <?php else: ?>
            <li class="pagination-next disabled"><span>&Gt;</span></li>
        <?php endif; ?>

    </ul><!-- ./pagination -->
    
<!-- </div> --><!-- ./pagination -->

<!-- <div style="text-align: center">
    <p>
        <small>
            Pagina <?php echo $this->_paginacion['actual']; ?> de <?php echo $this->_paginacion['total']; ?>
            
            <br>
            
            Registros por pagina: 
            <select id="registros" class="span1">
                <?php for($i = 10; $i <= 100; $i += 10): ?>
                    <option value="<?php echo $i; ?>" <?php if($i == $this->_paginacion['limite']){ echo 'selected="selected"'; } ?>  ><?php echo $i; ?></option>
                <?php endfor;?>
            </select>
        </small>
    </p>
</div> -->

<?php endif; ?>