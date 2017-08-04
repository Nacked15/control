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
                <a href="#adolescent" data-toggle="tab">ADOLESCENTS</a>
            </li>
            <li data-index="list_adults" class="list_adults" data-group="4">
                <a href="#adult" data-toggle="tab">ADULTS</a>
            </li>
            <li data-index="list_all" class="list_all" data-group="5">
                <a href="#all_students" data-toggle="tab">ADULTS</a>
            </li>
        </ul>
        <!-- <ul class="nav nav-tabs nav-justified nav-submenu" id="second_head" style="margin-bottom: 15px;">
            <li><a>DATOS DEL ALUMNO</a></li>
        </ul> -->
        <div id="myTabContent" class="tab-content well well-content">
 			<?php $this->renderFeedbackMessages(); ?>
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


<div id="studentDetails" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Eliminar Clase</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="well card-green">
                            <div class="card-avatar">
                                <img src="<?php echo Config::get('URL').Config::get('PATH_AVATARS_PUBLIC'); ?>avatar.png" alt="avatar"></div>
                            <div class="card-title"><h3 class="text-center">Avatar Name</h3></div>
                            <div class="card-body"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque sit alias iste quisquam porro odio accusantium placeat libero itaque eius, odit molestias corporis pariatur ullam quibusdam harum nulla impedit labore.</p></div>
                            <div class="card-footer"><label> extra information</label></div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="bs-component">
                            <ul class="nav nav-tabs well line-head" style="margin-bottom: 15px;">
                                <li class="active">
                                    <a href="#personal" data-toggle="tab">ALUMNO</a>
                                </li>
                                <li>
                                    <a href="#info_tutor" data-toggle="tab">EDUCACIÓN</a>
                                </li>
                                <li>
                                    <a href="#info_tutor" data-toggle="tab">TUTOR</a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content well line-body">
                                <?php $this->renderFeedbackMessages(); ?>
                                <div class="tab-pane fade active in" id="personal">
                                    <h4>Datos Personales</h4>
                                  <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                                </div>
                                <div class="tab-pane fade" id="info_tutor">
                                    <h4>Datos Academicos</h4>
                                  <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
                                </div>
                                <div class="tab-pane fade" id="info_tutor">
                                    <h4>Datos Del Tutor</h4>
                                  <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>