<!-- 
    TODO: HACER DINAMICO LOS GRUPOS, TOMANDO DE LA LOS GRUPOS QUE ESTEN EN LA
          EL LA TABLA COURSES. PARA QUE VAYAN APARECIENDO CONFORME SE VAN AGREGANDO
 -->
<?php $base_url = Config::get('URL'); ?>
<div class="container">
    <ol class="breadcrumb">
        <li><a href="<?= $base_url; ?>dashboard">Inicio</a></li>
        <li><a href="javascript:void(0)" class="active">Alumnos</a></li>
    </ol>    
    <div class="bs-component">
        <ul class="nav nav-tabs nav-justified nav-submenu menu_student_list" style="margin-bottom: 15px;">
            <li data-index="list_club" class="list_club" data-group="1">
                <a href="#club" data-toggle="tab">ENGLISH CLUB <span class="badge" id="cout1">0</span></a>
            </li>
            <li data-index="list_primary" class="list_primary" data-group="2">
                <a href="#primary" data-toggle="tab">PRIMARY <span class="badge" id="cout2">0</span></a>
            </li>
            <li data-index="list_adols" class="list_adols" data-group="3">
                <a href="#adolescent" data-toggle="tab">ADOLESCENTES <span class="badge" id="cout3">0</span></a>
            </li>
            <li data-index="list_adults" class="list_adults" data-group="4">
                <a href="#adult" data-toggle="tab">AVANZADO <span class="badge" id="cout4">0</span></a>
            </li>
            <?php if ($this->u_type === '1' || $this->u_type === '2'): ?>
            <li data-index="list_penddings" class="list_penddings" data-group="5">
                <a href="#penddings" data-toggle="tab">EN ESPERA <span class="badge" id="cout5">0</span></a>
            </li>
            <li data-index="list_all" class="list_all" data-group="6">
                <a href="#all_students" data-toggle="tab">TODOS <span class="badge" id="cout6">0</span></a>
            </li>
            <?php endif ?>
        </ul>
        <div id="myTabContent" class="tab-content well well-content">
 			<?php $this->renderFeedbackMessages(); ?>
            <div id="feed_msg" class="alert alert-dismissible alert-success" style="display: none;">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p id="message"></p>
            </div>
            <div class="tab-pane fade in list_club" id="club">
                
            </div>
            <div class="tab-pane fade in list_primary" id="primary">
                
            </div>
            <div class="tab-pane fade in list_adols" id="adolescent">
                
            </div>
            <div class="tab-pane fade in list_adults" id="adult">
                
            </div>
            
            <?php if ($this->u_type === '1' || $this->u_type === '2'): ?>
            <div class="tab-pane fade in list_penddings" id="penddings">
                
            </div>

            <div class="tab-pane fade in list_all" id="all_students">
                
            </div>
            <?php endif ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="add_to_group" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Agregar Alumno a Grupo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <p class="text-center"><small>Seleccione un curso de la lista, luego el grupo.</small></p>
                        <input type="hidden" id="alumno_id" class="form-control">
                        <div class="form-group">
                            <label class="col-sm-6"><small>Curso:</small> 
                                <select class="form-control " id="course">
                                    <option value="">Seleccione...</option>
                                    <?php if ($this->cursos): ?>
                                        <?php foreach ($this->cursos as $curso): ?>
                                            <option value="<?= $curso->course_id; ?>"><?= $curso->course; ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </label>
                            <label class="col-sm-6"><small>Grupo:</small> 
                                <select class="form-control" id="groups">
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 text-center">
                        <button type="button" id="add_in_group" class="btn btn-sm btn-second btn-raised">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="change_group" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Cambiar de Grupo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <p class="text-center"><small>Seleccione un curso y grupo a asignar.</small></p>
                        <input type="hidden" id="alumno_number" class="form-control">
                        <div class="form-group">
                            <label class="col-sm-6"><small>Curso:</small> 
                                <select class="form-control " id="course_list">
                                    <option value="">Seleccione...</option>
                                    <?php if ($this->cursos): ?>
                                        <?php foreach ($this->cursos as $curso): ?>
                                            <option value="<?= $curso->course_id; ?>"><?= $curso->course; ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                    <option value="0">EN ESPERA</option>
                                </select>
                            </label>
                            <label class="col-sm-6"><small>Grupo:</small> 
                                <select class="form-control" id="grupos">
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 text-center">
                        <button type="button" id="do_change_group" class="btn btn-sm btn-second btn-raised">Cambiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="invoice_list" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Facturación</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12" id="invoice_students_list">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalDeleteStudent" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header modal-delete">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Eliminar Alumno</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control text-center" id="alumno_id" />
                            <p class="text-center text-info">
                                ¿Está seguro de querer eliminar a: <br> <strong id="alumno_name"></strong>?
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="modal-footer col-md-10 col-md-offset-1 text-center">
                        <input type="button" 
                               data-dismiss="modal" 
                               class="btn btn-sm btn-raised btn-gray left" 
                               value="CANCELAR">
                        <input type="button"
                               id="btnConfirmDeleteStudent" 
                               class="btn btn-sm btn-raised btn-danger right" 
                               value="ELIMINAR">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalDeleteSelectedStudent" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header modal-delete">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Eliminar Alumnos</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control text-center" id="alumno_id" />
                            <p class="text-center text-info">
                                ¿Está seguro de querer eliminar a los <strong id="selected_students"></strong> alumnos seleccionados?
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="modal-footer col-md-10 col-md-offset-1 text-center">
                        <input type="button" 
                               data-dismiss="modal" 
                               class="btn btn-sm btn-raised btn-gray left" 
                               value="CANCELAR">
                        <input type="button" 
                               class="btn btn-sm btn-raised btn-danger right" 
                               id="btnConfirmDeleteStudents"
                               value="ELIMINAR">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>