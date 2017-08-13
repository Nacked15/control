<?php $base_url = Config::get('URL'); ?>
<div class="container">
    <ol class="breadcrumb">
        <li><a href="<?= $base_url; ?>dashboard">Inicio</a></li>
        <li><a href="javascript:void(0)" class="active">Alumnos</a></li>
    </ol>    
    <div class="bs-component">
        <ul class="nav nav-tabs nav-justified nav-submenu menu_student_list" id="head_menu" style="margin-bottom: 15px;">
            <li data-index="list_club" class="list_club" data-group="1">
                <a href="#club" data-toggle="tab">ENGLISH CLUB</a>
            </li>
            <li data-index="list_primary" class="list_primary" data-group="2">
                <a href="#primary" data-toggle="tab">PRIMARY</a>
            </li>
            <li data-index="list_adols" class="list_adols" data-group="3">
                <a href="#adolescent" data-toggle="tab">ADOLESCENTES</a>
            </li>
            <li data-index="list_adults" class="list_adults" data-group="4">
                <a href="#adult" data-toggle="tab">ADULTOS</a>
            </li>
            <li data-index="list_all" class="list_all" data-group="5">
                <a href="#all_students" data-toggle="tab">TODOS</a>
            </li>
        </ul>
        <!-- <ul class="nav nav-tabs nav-justified nav-submenu" id="second_head" style="margin-bottom: 15px;">
            <li><a>DATOS DEL ALUMNO</a></li>
        </ul> -->
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

            <div class="tab-pane fade in list_all" id="all_students">
                
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
                                            <option value="<?= $curso->id; ?>"><?= $curso->name; ?></option>
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