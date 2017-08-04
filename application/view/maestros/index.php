<div class="container">
    <ol class="breadcrumb">
          <li><a href="javascript:void(0)">Principal</a></li>
          <li><a href="javascript:void(0)" class="active">Maestros</a></li>
    </ol> 
    <ul class="nav nav-tabs nav-justified nav-submenu" id="second_head" style="margin-bottom: 15px;">
        <li><a>MAESTROS</a></li>
    </ul>   
    <div class="well">
        <div class="row">
            <div class="col-lg-8 col-md-10 col-lg-offset-2 col-md-offset-1">
                <button type="button" 
                        class="btn btn-sm btn-second right btn-raised"
                        data-toggle="modal" 
                        data-target="#addTeacher">Nuevo Maestro</button>
            </div>
            <div class="col-lg-8 col-md-10 col-lg-offset-2 col-md-offset-1">
                <?php $this->renderFeedbackMessages(); ?>
                <div class="table-responsive card-primary">
                    <?php if($this->maestros){ ?>
                    <table id="example" class="table table-bordered table-hover table-striped">
                        <thead>
                           <tr class="info">
                              <th>ID</th>
                              <th>Nombre</th>
                              <th>Apellido</th>
                              <th>Correo Electronico</th>
                              <th class="text-center">Opciones</th>
                           </tr>
                        </thead>
                        <tbody>
                        <?php  
                            foreach ($this->maestros as $maestro) {
                                echo '<tr>';
                                echo '<td>'.$maestro->user_id.'</td>';
                                echo '<td>'.$maestro->name.'</td>';
                                echo '<td>'.$maestro->lastname.'</td>';
                                echo '<td>'.$maestro->user_email.'</td>';
                                echo '<td class="text-center">
                                        <button type="button" 
                                                class="btn btn-xs btn-info btn-raised"
                                                data-toggle="modal" 
                                                data-target="#editTeacher">Editar</button>
                                        <button type="button" 
                                                class="btn btn-xs btn-danger btn-raised"
                                                data-toggle="modal" 
                                                data-target="#deleteTeacher">Eliminar</button>
                                     </td>';
                                echo '</tr>';
                            }
                        ?> 
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="addTeacher" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title">Registrar Nuevo Maestro</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12 text-center">
                    <form method="post" action="<?php echo Config::get('URL'); ?>register/register_action">
                        <div class="col-md-6">
                        <input type="text" 
                               pattern="[a-zA-Z\s]{3,60}" 
                               name="real_name"
                               class="form-control" 
                               placeholder="Nombre(s)" 
                               required /><br>
                        </div>
                        <div class="col-md-6">
                        <input type="text" 
                               pattern="[a-zA-Z\s]{2,64}" 
                               name="last_name"
                               class="form-control" 
                               placeholder="Apellido(s)" /><br>
                        </div>
                        <div class="col-md-6">
                        <select class="form-control" disabled>
                            <option value="3">Maestro</option>
                        </select><br>
                        <input type="hidden" class="form-control" name="user_type" value="3">
                        </div>
                        <div class="col-md-6">
                        <input type="text" 
                               pattern="[a-zA-Z0-9]{2,64}" 
                               name="user_name"
                               class="form-control" 
                               placeholder="Nombre de Usuario" 
                               required /><br>
                        </div>
                        <div class="col-md-12">
                        <input type="text" 
                               name="user_email"
                               class="form-control"
                               placeholder="Correo Electronico" 
                               required /><br>
                        </div>
                        <div class="col-md-6">
                        <input type="password" 
                               name="user_password_new"
                               class="form-control"
                               pattern=".{5,}" 
                               placeholder="Contraseña" 
                               required autocomplete="off" /><br>
                        </div>
                        <div class="col-md-6">
                        <input type="password" 
                               name="user_password_repeat"
                               class="form-control"
                               pattern=".{5,}" 
                               required 
                               placeholder="Repita Contraseña" 
                               autocomplete="off" /><br>
                        </div>
                        <div class="col-md-4 col-md-offset-4">
                        <input type="submit" 
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

<div id="editTeacher" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title">Actualizar Datos Del Maestro</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12 text-center">
                    <form method="post" action="<?php echo Config::get('URL'); ?>register/register_action">
                        <div class="col-md-6">
                        <input type="text" 
                               pattern="[a-zA-Z\s]{3,60}" 
                               name="real_name"
                               class="form-control" 
                               placeholder="Nombre(s)" 
                               required /><br>
                        </div>
                        <div class="col-md-6">
                        <input type="text" 
                               pattern="[a-zA-Z\s]{2,64}" 
                               name="last_name"
                               class="form-control" 
                               placeholder="Apellido(s)" /><br>
                        </div>
                        <div class="col-md-6">
                        <select class="form-control" disabled>
                            <option value="3">Maestro</option>
                        </select><br>
                        <input type="hidden" class="form-control" name="user_type" value="3">
                        </div>
                        <div class="col-md-6">
                        <input type="text" 
                               pattern="[a-zA-Z0-9]{2,64}" 
                               name="user_name"
                               class="form-control" 
                               placeholder="Nombre de Usuario" 
                               required /><br>
                        </div>
                        <div class="col-md-12">
                        <input type="text" 
                               name="user_email"
                               class="form-control"
                               placeholder="Correo Electronico" 
                               required /><br>
                        </div>
                        <div class="col-md-6">
                        <input type="password" 
                               name="user_password_new"
                               class="form-control"
                               pattern=".{5,}" 
                               placeholder="Contraseña" 
                               required autocomplete="off" /><br>
                        </div>
                        <div class="col-md-6">
                        <input type="password" 
                               name="user_password_repeat"
                               class="form-control"
                               pattern=".{5,}" 
                               required 
                               placeholder="Repita Contraseña" 
                               autocomplete="off" /><br>
                        </div>
                        <div class="col-md-4 col-md-offset-4">
                        <input type="submit" 
                               value="Actualizar" 
                               class="btn btn-md btn-second btn-raised center" />
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<div id="deleteTeacher" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header modal-delete">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Eliminar Maestro</h4>
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