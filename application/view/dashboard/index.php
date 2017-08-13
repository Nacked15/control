<div class="container">
    <ol class="breadcrumb">
          <li><a href="javascript:void(0)" class="active">Principal</a></li>
    </ol>    
    <!-- <div class="well"> -->
    <?php $this->renderFeedbackMessages(); ?>
    <div class="bs-component">
        <ul class="nav nav-tabs nav-submenu" style="margin-bottom: 15px;">
            <li class="active">
                <a href="#home" data-toggle="tab">Tareas</a>
            </li>
            <li>
                <a href="#calendario" data-toggle="tab">Calendario</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content well well-content">
            <div class="tab-pane fade active in" id="home">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6 text-left" style="margin-bottom: 10px;">
                            <small>Prioridades: </small>
                            <label class=" label label-primary">Normal</label>
                            <label class=" label label-warning">Alta</label>
                            <label class=" label label-success">Baja</label>
                            <div class="togglebutton">
                              <label>
                                Wi-Fi
                                <input checked="" type="checkbox">
                              </label>
                            </div>
                            <div class="togglebutton">
                              <label>
                                Bluetooth
                                <input type="checkbox">
                              </label>
                            </div>
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <input checked="" type="checkbox"> Auto-updates
                                </label>
                              </div>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right" style="margin-bottom: 15px;">
                            <button type="button" 
                                    class="btn btn-main btn-raised btn-xs btn-add"
                                    data-toggle="modal" 
                                    data-target="#newTask">
                                <i class="glyphicon glyphicon-plus"></i> Nuevo
                            </button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12" id="task_list"></div>
                </div>

                <span data-toggle=snackbar
                      data-content="Nuevo recordatorio creado!"
                      data-timeout="3200"
                      data-html-allowed="true"
                      id="new_snack">
                </span>

                <span data-toggle=snackbar
                      data-content="Recordatorio eliminado!"
                      data-timeout="3200"
                      data-html-allowed="true"
                      id="del_snack">
                </span>
            </div>
            <div class="tab-pane fade" id="calendario">
                <div class="row">
                    <div class="col-md-12">
                        <div class="calendar card-primary">
                            <div class="row">
                                <div class="col-xs-6 col-xs-offset-3 text-center loader">
                                    <h4 class="text-center">Cargando..</h4>
                                    <img src="<?= Config::get('URL');?>public/assets/img/loading.gif">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>

<span data-toggle=snackbar
      data-content="Hay campos vacios!"
      data-timeout="3000"
      data-html-allowed="true"
      id="empty_snack">
</span>

<div id="newTask" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Nuevo Recordatorio</h4>
            </div>
            <div class="modal-body">
                <form id="form_new_task">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1" style="margin-bottom: 20px;">
                            <div class="form-group">
                                <label class="col-md-4 text-right">Fecha de Cierre:</label>
                                <div class="col-md-8">
                                    <input type="text" id="date_todo" name="fecha_evento" class="form-control" required="true">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-10 col-md-offset-1 text-center" style="margin-bottom: 15px;">
                            <label>Prioridad:</label>
                            <div class="radio radio-inline radio-warning" style="margin-top: 0;">
                                <label>
                                <input type="radio" name="priority" id="optionsRadios1" value="1">
                                    <small class="label label-warning">&nbsp;&nbsp; Alta &nbsp;&nbsp;</small>
                                </label>
                            </div>
                            <div class="radio radio-inline radio-primary">
                                <label>
                                <input type="radio" name="priority" id="optionsRadios2" value="2" checked>
                                    <small class="label label-primary">Normal</small>
                                </label>
                            </div>
                            <div class="radio radio-inline radio-success">
                                <label>
                                <input type="radio" name="priority" id="optionsRadios3" value="3">
                                    <small class="label label-success">&nbsp;&nbsp; Baja &nbsp;&nbsp;</small>
                                </label>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 text-center">
                            <label for="group_name">Descripción:</label>
                            <textarea id="event" name="event" rows="6" class="form-control texto" required="true"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="modal-footer col-sm-10 col-sm-offset-1 text-center">
                    <button type="button" class="btn btn-sm btn-naatik btn-raised left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_save_task" class="btn btn-sm btn-second btn-raised right">Guardar</button>
                </div>             
            </div>
        </div>
    </div>
</div>

<div id="editTask" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Editar Recordatorio</h4>
            </div>
            <div class="modal-body">
                <form id="form_update_task">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1" style="margin-bottom: 18px;">
                            <div class="form-group">
                                <label class="col-md-4 text-right">Fecha de Cierre:</label>
                                <div class="col-md-8">
                                    <input type="hidden" id="id_task" name="evento_id" class="form-control">
                                    <input type="text" id="edit_date_todo" name="fecha_evento" class="form-control" required="true">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-10 col-md-offset-1 text-center" style="margin-bottom: 15px;">
                            <label>Prioridad:</label>
                            <div class="radio radio-inline radio-warning" style="margin-top: 0;">
                                <label>
                                <input type="radio" name="priority" id="edit_opt1" value="1">
                                    <small class="label label-warning">&nbsp;&nbsp; Alta &nbsp;&nbsp;</small>
                                </label>
                            </div>
                            <div class="radio radio-inline radio-primary">
                                <label>
                                <input type="radio" name="priority" id="edit_opt2" value="2">
                                    <small class="label label-primary">Normal</small>
                                </label>
                            </div>
                            <div class="radio radio-inline radio-success">
                                <label>
                                <input type="radio" name="priority" id="edit_opt3" value="3">
                                    <small class="label label-success">&nbsp;&nbsp; Baja &nbsp;&nbsp;</small>
                                </label>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 text-center">
                            <label for="group_name">Descripción:</label>
                            <textarea id="edit_event" name="event" rows="8" class="form-control texto" required="true"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="modal-footer col-sm-10 col-sm-offset-1 text-center">
                    <button type="button" class="btn btn-sm btn-naatik btn-raised left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_update_task" class="btn btn-sm btn-second btn-raised right">Guardar</button>
                </div>             
            </div>
        </div>
    </div>
</div>

<div id="detailTask" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Vista Detallada</h4>
            </div>
            <div class="modal-body">
                <form id="form_update_task">
                    <div class="row">
                        <div class="col-md-6 text-center" style="margin-bottom: 5px;">
                            <div class="form-group">
                                <h4 class="text-primary">Fecha de Cierre:</h4>
                                <strong id="date_memo"></strong>
                            </div>
                        </div>
                        <div class="col-md-6 text-center" style="margin-bottom: 5px;">
                            <h4 class="text-primary">Prioridad:</h4>
                            <label id="prior" class="label"></label>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 text-center">
                            <h4 class="text-primary">Descripción:</h4>
                            <textarea cols="60" rows="15" id="detail_event" disabled></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="modal-footer col-sm-10 col-sm-offset-1 text-center">
                    <button type="button" class="btn btn-sm btn-naatik btn-raised left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_update_task" class="btn btn-sm btn-second btn-raised right">Guardar</button>
                </div>             
            </div>
        </div>
    </div>
</div>

<div id="delete_task" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header modal-delete">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Eliminar Recordatorio</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Seguro de que quiere eliminar este recordatorio?</p>
                <input type="hidden" id="delete_task_id">
            </div>
            <div class="row">
                <div class="modal-footer col-sm-10 col-sm-offset-1 text-center">
                    <button type="button" id="btn_confirm_delete" class="btn btn-sm btn-second btn-raised left">Eliminar</button>
                    <button type="button" class="btn btn-sm btn-gray btn-raised right" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
