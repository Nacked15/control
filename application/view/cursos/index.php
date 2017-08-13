<div class="container">
    <ol class="breadcrumb">
        <li><a href="javascript:void(0)">Principal</a></li>
        <li><a href="javascript:void(0)" class="active">Clases</a></li>
    </ol>    
    <!-- <div class="well"> -->
    <div class="bs-component">
        <ul class="nav nav-tabs nav-justified nav-submenu" id="menu_clase" style="margin-bottom: 15px;">
            <li id="t1" class="tab" data-index="1">
                <a href="#v_clases" data-toggle="tab">CLASES</a>
            </li>
            <li id="t2" class="tab" data-index="2">
                <a href="#v_cursos" data-toggle="tab">CURSOS</a>
            </li>
            <li id="t3" class="tab" data-index="3">
                <a href="#v_horario" data-toggle="tab">HORARIO</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content well well-content">
        <?php $this->renderFeedbackMessages(); ?>
            <div class="tab-pane fade in" id="v_clases">
                <div class="row">
                    <div class="col-sm-12">
                        <button type="button"
                                id="addClase" 
                                class="btn btn-sm btn-main btn-raised btn-add">
                                <i class="glyphicon glyphicon-plus"></i> Nueva Clase
                        </button>
                        <div class="card-primary" id="lista_clases">
                            <div class="row">
                                <div class="col-xs-6 col-xs-offset-3 text-center loader">
                                    <h4 class="text-center">Cargando..</h4>
                                    <img src="<?= Config::get('URL');?>public/assets/img/loader.gif">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="v_cursos">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" 
                                class="btn btn-sm btn-main btn-tiny btn-raised btn-add"
                                data-toggle="modal" 
                                data-target="#addCourse">
                                <i class="glyphicon glyphicon-plus"></i> Nuevo Curso</button>
                        <div class="card-primary" id="cursos_list">
                            <div class="row">
                                <div class="col-xs-6 col-xs-offset-3 text-center loader">
                                    <h4 class="text-center">Cargando..</h4>
                                    <img src="<?= Config::get('URL');?>public/assets/img/loader.gif">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button type="button"
                                id="btn_new_group" 
                                class="btn btn-sm btn-main btn-tiny btn-raised btn-add"
                                data-toggle="modal" 
                                data-target="#addGroup">
                                <i class="glyphicon glyphicon-plus"></i> Nuevo Grupo</button>
                        <div id="grupos_list" class="card-primary">
                            <div class="row">
                                <div class="col-xs-6 col-xs-offset-3 text-center loader">
                                    <h4 class="text-center">Cargando..</h4>
                                    <img src="<?= Config::get('URL');?>public/assets/img/loader.gif">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="v_horario">
                <div class="row">
                    <div class="col-md-12 card-primary">
                        <div id="horario_list">
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
</div>

<div id="addCourse" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title">Nuevo Curso</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 text-center">
                    <label for="new_course_name">Nombre del Curso:</label>
                    <input type="text" 
                           id="new_course_name" 
                           name="new_course_name" 
                           class="form-control text-center" required>
                </div>
            </div>
            </div>
            <div class="row">
                <div class="modal-footer col-md-10 col-md-offset-1 text-center">
                    <button type="button" class="btn btn-sm btn-naatik btn-raised left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="new_course" class="btn btn-second btn-sm btn-raised right">Crear</button>
                </div>             
            </div>
        </div>
    </div>
</div>

<div id="editCourse" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title">Editar Curso</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 text-center">
                    <label for="course_name">Nombre del Curso:</label>
                    <input type="text" 
                           id="course_name" 
                           name="course_name"
                           class="form-control text-center" 
                           required>
                    <input type="hidden" 
                           id="course_id"  
                           class="form-control">
                </div>
            </div>
            </div>
            <div class="row">
                <div class="modal-footer col-md-10 col-md-offset-1 text-center">
                    <button type="button" class="btn btn-sm btn-naatik btn-raised left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_update_course" class="btn btn-sm btn-second btn-raised right">Guardar</button>
                </div>             
            </div>
        </div>
    </div>
</div>

<div id="addGroup" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title">Nuevo Grupo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center">
                        <label for="new_group_name">Nombre del Grupo:</label>
                        <input type="text" 
                               id="new_group_name" 
                               name="new_group_name" 
                               class="form-control text-center" required>
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="modal-footer col-md-10 col-md-offset-1 text-center">
                    <button type="button" class="btn btn-sm btn-naatik btn-raised left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="new_group" class="btn btn-sm btn-second btn-raised right">Crear</button>
                </div>             
            </div>
        </div>
    </div>
</div>

<div id="editGroup" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title">Actualizar Grupo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center">
                        <label for="group_name">Nombre del Grupo:</label>
                        <input type="text" 
                               id="group_name"  
                               class="form-control text-center" required>
                        <input type="hidden" 
                               id="group_id"  
                               class="form-control">
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="modal-footer col-md-10 col-md-offset-1 text-center">
                    <button type="button" class="btn btn-sm btn-naatik btn-raised left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="update_group" class="btn btn-sm btn-second btn-raised right">Guardar</button>
                </div>             
            </div>
        </div>
    </div>
</div>

<div id="deleteClass" class="modal fade in">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header modal-delete">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Eliminar Clase</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Eliminar <strong id="clase_name"></strong>?</p>
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

<div id="deleteGroup" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header modal-delete">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Eliminar Grupo</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Eliminar <strong id="g_name"></strong>?</p>
                <input type="hidden" id="delete_group_id">
            </div>
            <div class="row">
                <div class="modal-footer col-sm-8 col-sm-offset-2 text-center">
                    <button type="button" class="btn btn-sm btn-gray btn-raised left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="delete_group" class="btn btn-sm btn-danger btn-raised right">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>