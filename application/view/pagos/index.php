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
<div id="modalPayMonth" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h5 class="modal-title text-center">Mensualidad: <span id="month_name"></span></h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="text-center">Alumno: <strong id="student_name"></strong></p>
                        <input type="hidden" id="student_id" class="form-control">
                        <input type="hidden" id="month_to_pay" class="form-control">
                        <div class="form-group">
                                <select class="form-control" id="pay_action">
                                    <option value="" hidden>- - - &nbsp;&nbsp; Seleccione &nbsp;&nbsp;- - -</option>
                                    <option value="1">Pagar</option>
                                    <!-- Ya no aplica -->
                                    <!-- <option value="2">Becado</option> -->
                                    <option value="3">No Aplica</option>
                                    <option value="0">Adeudo</option>
                                </select>
                        </div>
                        <h6 class="text-center text-success" id="response"></h6>
                    </div>
                    <div class="col-sm-6 text-center">
                        <button type="button" data-dismiss="modal" class="btn btn-sm btn-default btn-raised">Cancelar</button>
                    </div>
                    <div class="col-sm-6 text-center">
                        <button type="button" id="toggle_pay" class="btn btn-sm btn-second btn-raised">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="add_comment_modal" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Agregar Comentario</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <input type="hidden" id="id_alumno" class="form-control">
                        <div class="form-group row">
                            <label class="col-sm-12 text-center">Escriba su Comentario:</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" rows="4" id="comment" name="comment"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 text-center">
                        <button type="button" id="save_comment" class="btn btn-sm btn-second btn-raised">Guardar</button>
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