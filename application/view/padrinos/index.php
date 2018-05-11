<?php $base_url = Config::get('URL'); ?>
<div class="container">
    <ol class="breadcrumb">
          <li><a href="<?= $base_url; ?>dashboard">Principal</a></li>
          <li><a href="javascript:void(0)" class="active">Parinos</a></li>
    </ol> 
    <ul class="nav nav-tabs nav-justified nav-submenu" id="second_head" style="margin-bottom: 15px;">
        <li class="active"><a>PADRINOS</a></li>
    </ul>   
    <div class="well">
        <div class="row">
            <div class="col-md-12">
                <button type="button" 
                        class="btn btn-sm btn-second right btn-raised"
                        id="btnAddSponsor">Nuevo Padrino</button>
                <?php $this->renderFeedbackMessages(); ?>
            </div>
            <div class="col-md-12" id="sponsors_list">
                
            </div>
        </div>
    </div>
</div>


<div id="modalAddNewSponsor" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title">Registrar Nuevo Padrino</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12 text-center">
                    <form id="frmNewSponsor" method="post">
                        <div class="col-md-6">
                            <input type="text" 
                                   pattern="[a-zA-Z\s]{3,60}" 
                                   name="sponsor_name"
                                   class="form-control" 
                                   placeholder="Nombre(s)" 
                                   required /><br>
                        </div>
                        <div class="col-md-6">
                            <input type="text" 
                                   pattern="[a-zA-Z\s]{2,64}" 
                                   name="sponsor_lastname"
                                   class="form-control" 
                                   placeholder="Apellido(s)" /><br>
                        </div>
                        <div class="col-md-6">
                            <input type="email" 
                                   name="sponsor_email"
                                   class="form-control"
                                   placeholder="Correo Electronico" /><br>
                        </div>
                        <div class="col-md-6">
                            <input type="text" 
                                   name="sponsor_type"
                                   class="form-control"
                                   placeholder="Tipo de Padrino" 
                                   autocomplete="off" /><br>
                        </div>
                        <div class="col-md-12">
                            <label for="group_name">Descripción:</label>
                            <textarea name="description" 
                                      rows="3" 
                                      class="form-control texto" ></textarea>
                        </div>
                        <div class="col-md-8 col-md-offset-2 text-center">
                            <label for="becario">Becario</label>
                            <select class="form-control" name="becario">
                                <option value=""></option>
                            </select><br>
                        </div>
                        
                        <div class="col-md-4 col-md-offset-4">
                            <input type="button"
                                   id="saveNewSponsor"
                                   value="Registrar" 
                                   class="btn btn-md btn-second btn-raised center" />
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<div id="modalEditSponsor" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title">Editar Datos Del Padrino</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12 text-center">
                    <form method="post" action="frmEditSponsor">
                        <div class="col-md-6">
                            <input type="hidden" class="form-control" id="sponsor_id" name="sponsor_id">
                            <input type="text" 
                                   id="edit_name"
                                   name="edit_name"
                                   class="form-control" 
                                   placeholder="Nombre(s)" 
                                   required /><br>
                        </div>
                        <div class="col-md-6">
                        <input type="text" 
                               id="edit_lastname"
                               name="edit_lastname"
                               class="form-control" 
                               placeholder="Apellido(s)" /><br>
                        </div>
                        <div class="col-md-6">
                        <input type="text"
                               id="edit_email"  
                               name="edit_email"
                               class="form-control"
                               placeholder="Correo Electronico" 
                               required /><br>
                        </div>
                        <div class="col-md-6">
                        <input type="text" 
                               id="edit_type"
                               name="edit_type"
                               class="form-control" 
                               placeholder="Nombre de Usuario" 
                               required /><br>
                        </div>
                        <div class="col-md-12">
                            <label for="group_name">Descripción:</label>
                            <textarea name="edit_description"
                                      id="edit_description" 
                                      rows="3" 
                                      class="form-control texto" ></textarea>
                        </div>
                        <div class="col-md-8 col-md-offset-2 text-center">
                            <label for="becario">Becario</label>
                            <select class="form-control" name="edit_becario" id="edit_becario">
                                <option value=""></option>
                            </select><br>
                        </div>
                        <div class="col-md-4 col-md-offset-4">
                            <input type="button" 
                                   value="Actualizar" 
                                   id="btn_save_sponsor" 
                                   class="btn btn-md btn-second btn-raised center" />
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<div id="modalDeleteSponsor" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header modal-delete">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Eliminar Padrino</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Eliminar <strong id="name_sponsor"></strong>?</p>
                <input type="hidden" id="delete_clase_id">
            </div>
            <div class="row">
                <div class="modal-footer col-sm-8 col-sm-offset-2 text-center">
                    <button type="button" class="btn btn-sm btn-gray btn-raised left" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-danger btn-raised right">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>