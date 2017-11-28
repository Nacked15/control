<?php $base_url = Config::get('URL'); ?>
<div class="container extended">
    <ol class="breadcrumb">
        <li><a href="<?= $base_url; ?>dashboard">Inicio</a></li>
        <li><a href="javascript:void(0)" class="active">Pagos</a></li>
    </ol>    
    <div class="bs-component">
        <ul class="nav nav-tabs nav-justified nav-submenu menu_pay_list" style="margin-bottom: 15px;">
            <li data-index="paylist_club" class="paylist_club" data-group="1">
                <a href="#club" data-toggle="tab">ENGLISH CLUB</a>
            </li>
            <li data-index="paylist_primary" class="paylist_primary" data-group="2">
                <a href="#primary" data-toggle="tab">PRIMARY</a>
            </li>
            <li data-index="paylist_adols" class="paylist_adols" data-group="3">
                <a href="#adolescent" data-toggle="tab">ADOLESCENTES</a>
            </li>
            <li data-index="paylist_adults" class="paylist_adults" data-group="4">
                <a href="#adult" data-toggle="tab">AVANZADO</a>
            </li>
            <li data-index="paylist_all" class="paylist_all" data-group="6">
                <a href="#all_students" data-toggle="tab">TODOS</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content well well-content">
            <div class="tab-pane fade in paylist_club" id="pay_club">
                
            </div>

            <div class="tab-pane fade in paylist_primary" id="pay_primary">
                
            </div>

            <div class="tab-pane fade in paylist_adols" id="pay_adolescent">
                
            </div>

            <div class="tab-pane fade in paylist_adults" id="pay_adult">
                
            </div>

            <div class="tab-pane fade in paylist_all" id="pay_all">
                
            </div>
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