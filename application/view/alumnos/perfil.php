<div class="container">
    <ol class="breadcrumb">
        <li><a href="<?= $base_url; ?>dashboard">Inicio</a></li>
        <li><a href="<?= Config::get('URL'); ?>alumno">Alumnos</a></li>
        <li><a href="javascript:void(0)" class="active">Perfil Alumno</a></li>
    </ol>
    <div class="bs-component">
        <div class="well">
        <?php if ($this->alumno): 
            $url_base = Config::get('URL');
            $url_avatar = $url_base.Config::get('PATH_AVATAR_STUDENT');
        ?>
        <?php foreach ($this->alumno as $alumno):?>
        <div class="row">
            <div class="col-md-2 col-sm-3 text-left">
                <a href="<?= Config::get('URL'); ?>alumno" class="btn btn-naatik btn-tiny btn-sm">
                    Volver
                </a>
            </div>           
            <div class="col-md-8 col-sm-6">
                <h4 class="text-center text-info text-title">DATOS DEL ALUMNO</h4>
            </div>
            <div class="col-md-2 col-sm-3">
                <h4 class="text-center text-warning">
                <div class="togglebutton">
                    <label>
                        DE BAJA: &nbsp;
                        <input data-id="<?= $alumno->id; ?>"
                               data-name="<?= $alumno->nombre.' '.$alumno->ape_pat;?>"  
                               id="check_out"
                               <?= $alumno->status !== '1' ? 'checked' : ''; ?>
                               type="checkbox">
                    </label>
                </div>
                </h4>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-3" style="margin-bottom: 15px;">
                <div class="card">
                    <div class="card-avatar">
                        <img src="<?= $url_avatar.$alumno->avatar;?>.jpg" alt="avatar">
                    </div>
                    <div class="card-title">
                        <h4 class="text-center text-naatik">
                            <?= $alumno->nombre.' '.$alumno->ape_pat;?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <ul class="card-list">
                            <li>
                                <b>Grupo:</b>
                                <?php if ($alumno->clase): ?>
                                    <?php foreach ($alumno->clase as $clase): ?>
                                        <?= $clase->curso.' '.$clase->grupo; ?>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <a class="link adding_group"
                                       data-student="<?= $alumno->id; ?>" 
                                       data-toggle="modal" 
                                       data-target="#add_to_group"  
                                       title="Agregar grupo"><strong>Agregar a Grupo</strong></a>
                                <?php endif ?>
                            </li>
                            <li><b>Edad:</b> <?= $alumno->age; ?> Años</li>
                            <li><b>Número Celular:</b> <?= $alumno->cellphone; ?></li>
                            <?php if ($alumno->tutor): ?>
                                <?php foreach ($alumno->tutor as $tutor): ?>
                                <li><b>Tutor: </b><?= $tutor->name.' '.$tutor->surname.' '.$tutor->lastname; ?></li>
                                <li><b>Tel. de Casa: </b><?= $tutor->phone; ?></li>
                                <li><b>Tel. Celular: </b><?= $tutor->cellphone; ?></li>
                                <li><b>Tel. Alterno: </b> <?= $tutor->phone2; ?></li>
                                <?php endforeach ?>
                            <?php endif ?>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <label>Fecha de Inscripción: <br> <?= $alumno->begun_at; ?></label>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <?php $this->renderFeedbackMessages(); ?>
                <div class="bs-component">
                    <ul class="nav nav-tabs well line-head" style="margin-bottom: 15px;">
                        <li class="active">
                            <a href="#info_student" data-toggle="tab">DATOS DEL ALUMNO</a>
                        </li>
                        <li>
                            <a href="#info_tutor" data-toggle="tab">DATOS DEL TUTOR</a>
                        </li>
                        <li>
                            <a href="#update_info" data-toggle="tab">DATOS ACADEMICOS</a>
                        </li>
                        <li>
                            <a href="#update_map" data-toggle="tab">MAPA</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content well line-body">
                        
                        <div class="tab-pane fade active in" id="info_student">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="data-box">
                                    <h4>Datos Del Alumno</h4>
                                    <form action="<?= Config::get('URL'); ?>alumno/actualizarDatosAlumno" class="form-horizontal" method="POST">
                                        <div class="form-group">
                                            <label for="dia" class="col-sm-12 text-center"><small>Nombre Completo:</small></label>
                                            <div class="col-sm-4">
                                                <input type="hidden" name="student_id" value="<?= $alumno->id; ?>">
                                                <input type="hidden" name="tutor_id" value="<?= $alumno->id_tutor; ?>">
                                               <input type="text" 
                                                      class="form-control text-center" 
                                                      id="surname" 
                                                      name="surname" 
                                                      value="<?= $alumno->ape_pat; ?>"
                                                      pattern="[a-zA-Z\s]{3,60}"
                                                      autocomplete="off" required>
                                            </div>
                                            <div class="col-sm-4">
                                               <input type="text" 
                                                      class="form-control text-center" 
                                                      id="lastname" 
                                                      name="lastname" 
                                                      value="<?= $alumno->ape_mat; ?>"
                                                      pattern="[a-zA-Z\s]{3,60}" 
                                                      autocomplete="off" required>
                                            </div>
                                            <div class="col-sm-4">
                                               <input type="text" 
                                                      class="form-control text-center" 
                                                      id="name" 
                                                      name="name" 
                                                      value="<?= $alumno->nombre; ?>"
                                                      pattern="[a-zA-Z\s]{3,60}"
                                                      autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-sm-6"><small>Fecha de Nacimiento:</small> 
                                                <input type="text" 
                                                       class="form-control" 
                                                       id="bornday" 
                                                       name="birthdate" 
                                                       value="<?= $alumno->birthdate; ?>">
                                            </label>
                                            <label class="col-md-4 col-sm-6"><small>Sexo:</small> 
                                                <select class="form-control" name="genre">
                                                    <option <?= $alumno->genre == 'Masculino' ? 'selected' : ''; ?> value="Masculino">Masculino</option>
                                                    <option <?= $alumno->genre == 'Femenino' ? 'selected' : ''; ?> value="Femenino">Femenino</option>
                                                </select>
                                            </label>
                                            <label class="col-md-4 col-sm-6"><small>Estado Civil:</small> 
                                                <select class="form-control" name="edo_civil">
                                                    <option <?= $alumno->edo_civil == 'Soltero(a)' ? 'selected' : ''; ?> value="Soltero(a)">Soltero(a)</option>
                                                    <option <?= $alumno->edo_civil == 'Casado(a)' ? 'selected' : ''; ?> value="Casado(a)">Casado(a)</option>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6"><small>Número Celular:</small> 
                                                <input type="tel" 
                                                       class="form-control"  
                                                       name="cellphone" 
                                                       value="<?= $alumno->cellphone; ?>"
                                                       pattern="[0-9\s]{8,15}">
                                            </label>
                                            <label class="col-sm-6"><small>Referencia de Domicilio:</small> 
                                                <input type="tel" 
                                                       class="form-control"  
                                                       name="reference" 
                                                       value="<?= $alumno->reference; ?>">
                                            </label>
                                        </div>
                                        <?php foreach ($alumno->address as $address): ?>
                                        <div class="form-group">
                                            <label for="dia" class="col-sm-12">Dirección:</label>
                                            <label class="col-md-3 col-sm-4"><small>Calle:</small>
                                               <input type="text" 
                                                      class="form-control" 
                                                      name="street" 
                                                      value="<?= $address->calle; ?>">
                                            </label>
                                            <label class="col-md-3 col-sm-4"><small>Número:</small>
                                               <input type="text" 
                                                      class="form-control" 
                                                      name="number" 
                                                      value="<?= $address->numero; ?>">
                                            </label>
                                            <label class="col-md-3 col-sm-4"><small>Entre:</small>
                                               <input type="text" 
                                                      class="form-control" 
                                                      name="between" 
                                                      value="<?= $address->entre; ?>">
                                            </label>
                                            <label class="col-md-3 col-sm-4"><small>Colonia:</small>
                                               <input type="text" 
                                                      class="form-control"  
                                                      name="colony" 
                                                      value="<?= $address->colonia; ?>">
                                            </label>
                                        </div>
                                        <?php endforeach ?>
                                        <div class="form-group">
                                            <label class="col-sm-6"><small>Padecimientos:</small> 
                                                <input type="tel" 
                                                       class="form-control"  
                                                       name="sickness" 
                                                       value="<?= $alumno->sickness; ?>">
                                            </label>
                                            <label class="col-sm-6"><small>Tratamiento:</small> 
                                                <input type="tel" 
                                                       class="form-control"  
                                                       name="medication" 
                                                       value="<?= $alumno->medication; ?>">
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-sm-6"><small>¿Es de familia Homestay?:</small> 
                                                <div class="radio radio-info">
                                                    <label> No
                                                        <input type="radio" 
                                                               <?= $alumno->homestay == '0' ? 'checked' : ''; ?> 
                                                               value="0" 
                                                               name="homestay">
                                                        <span class="circle"></span><span class="check"></span>
                                                    </label>
                                                    <label></label>
                                                    <label> SI
                                                        <input type="radio"
                                                               <?= $alumno->homestay == '1' ? 'checked' : ''; ?>
                                                               value="1" 
                                                               name="homestay">
                                                        <span class="circle"></span><span class="check"></span>
                                                    </label>
                                                </div>
                                            </label>
                                            <label class="col-md-4 col-sm-6"><small>¿Entregó Acta de Nacimiento?:</small> 
                                                <div class="radio radio-info">
                                                    <label> No
                                                        <input type="radio" 
                                                               value="0"
                                                               <?= $alumno->acta == '0' ? 'checked' : ''; ?> 
                                                               name="acta">
                                                        <span class="circle"></span><span class="check"></span>
                                                    </label>
                                                    <label></label>
                                                    <label> SI
                                                        <input type="radio" 
                                                               value="1" 
                                                               <?= $alumno->acta == '1' ? 'checked' : ''; ?>
                                                               name="acta">
                                                        <span class="circle"></span><span class="check"></span>
                                                    </label>
                                                </div>
                                            </label>
                                            <label class="col-md-4 col-sm-6"><small>¿Requiere Factura?:</small> 
                                                <div class="radio radio-info">
                                                    <label> No
                                                        <input type="radio"
                                                               value="0" 
                                                               <?= $alumno->invoice == '0' ? 'checked' : ''; ?>
                                                               name="invoice">
                                                        <span class="circle"></span><span class="check"></span>
                                                    </label>
                                                    <label></label>
                                                    <label> SI
                                                        <input type="radio" 
                                                               value="1" 
                                                               <?= $alumno->invoice == '1' ? 'checked' : ''; ?>
                                                               name="invoice">
                                                        <span class="circle"></span><span class="check"></span>
                                                    </label>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12"><small>Comentario sobre el alumno(a):</small> 
                                                <textarea name="comment" rows="3" class="form-control texto"><?= $alumno->comment; ?></textarea>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12 text-center">
                                                <button type="submit" class="btn btn-sm btn-second btn-raised">Actualizar</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="info_tutor">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="data-box">
                                    <h4>Datos Del Tutor</h4>
                                    <form action="<?= Config::get('URL'); ?>alumno/actualizarDatosTutor" method="POST" class="form-horizontal">
                                        <?php if ($alumno->tutor): ?>
                                            <?php foreach ($alumno->tutor as $tutor): ?>
                                            <div class="form-group">
                                                <label class="col-sm-12 text-center">
                                                    <small>Nombre Completo:</small></label>
                                                <input type="hidden" name="alumno" value="<?= $alumno->id; ?>">
                                                <input type="hidden" name="id_tutor" value="<?= $tutor->id; ?>">
                                                <div class="col-sm-4">
                                                    <input type="text" 
                                                           class="form-control text-center" 
                                                           id="apellido_pat" 
                                                           name="ape_pat"
                                                           pattern="[a-zA-Z\s]{3,60}" 
                                                           value="<?= $tutor->surname; ?>" 
                                                           autocomplete="off">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" 
                                                           class="form-control text-center" 
                                                           id="apellido_pat" 
                                                           name="ape_mat"
                                                           pattern="[a-zA-Z\s]{3,60}" 
                                                           value="<?= $tutor->lastname; ?>" 
                                                           autocomplete="off">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" 
                                                           class="form-control text-center" 
                                                           id="nombre_tutor" 
                                                           name="nombre_tutor"
                                                           pattern="[a-zA-Z\s]{3,60}" 
                                                           value="<?= $tutor->name; ?>" 
                                                           autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4"><small>Ocupación:</small> 
                                                    <input type="tel" 
                                                           class="form-control" 
                                                           id="ocupacion" 
                                                           name="ocupacion" 
                                                           value="<?= $tutor->job; ?>"
                                                           autocomplete="off">
                                                </label>
                                                <label class="col-sm-4"><small>Parentesco:</small> 
                                                    <select class="form-control " name="parentesco">
                                                        <option value="">Seleccione...</option>
                                                        <option <?= $tutor->relation == 'Madre' ? 'selected' : ''; ?> value="Madre">Madre</option>
                                                        <option <?= $tutor->relation == 'Padre' ? 'selected' : ''; ?> value="Padre">Padre</option>
                                                        <option <?= $tutor->relation == 'Abuelo(a)' ? 'selected' : ''; ?> value="Abuelo(a)">Abuelo(a)</option>
                                                        <option <?= $tutor->relation == 'Hermano(a)' ? 'selected' : ''; ?> value="Hermano(a)">Hermano(a)</option>
                                                        <option <?= $tutor->relation == 'Tio(a)' ? 'selected' : ''; ?> value="Tio(a)">Tío(a)</option>
                                                        <option <?= $tutor->relation == 'Tutor' ? 'selected' : ''; ?> value="Tutor">Tutor</option>
                                                    </select>
                                                </label>
                                                <label class="col-sm-4"><small>Teléfono de Casa:</small> 
                                                    <input type="tel" 
                                                           class="form-control" 
                                                           id="tel_casa" 
                                                           name="tel_casa" 
                                                           value="<?= $tutor->phone; ?>" 
                                                           pattern="[0-9\s]{8,15}"
                                                           autocomplete="off">

                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4"><small>Teléfono Celular:</small> 
                                                    <input type="tel" 
                                                           class="form-control" 
                                                           id="tel_celular" 
                                                           name="tel_celular" 
                                                           value="<?= $tutor->cellphone; ?>"
                                                           pattern="[0-9\s]{8,15}"
                                                           autocomplete="off">
                                                </label>
                                                <label class="col-sm-4"><small>Otro Familiar:</small> 
                                                    <select class="form-control " name="familiar">
                                                        <option value="">Seleccione...</option>
                                                        <option <?= $tutor->family == 'Madre' ? 'selected' : ''; ?> value="Madre">Madre</option>
                                                        <option <?= $tutor->family == 'Padre' ? 'selected' : ''; ?> value="Padre">Padre</option>
                                                        <option <?= $tutor->family == 'Abuelo(a)' ? 'selected' : ''; ?> value="Abuelo(a)">Abuelo(a)</option>
                                                        <option <?= $tutor->family == 'Hermano(a)' ? 'selected' : ''; ?> value="Hermano(a)">Hermano(a)</option>
                                                        <option <?= $tutor->family == 'Tio(a)' ? 'selected' : ''; ?> value="Tio(a)">Tío(a)</option>
                                                        <option <?= $tutor->family == 'Tutor' ? 'selected' : ''; ?> value="Tutor">Tutor</option>
                                                    </select>
                                                </label>
                                                <label class="col-sm-4"><small>Teléfono de Familiar:</small> 
                                                    <input type="tel" 
                                                           class="form-control" 
                                                           id="tel_familiar" 
                                                           name="tel_familiar" 
                                                           value="<?= $tutor->phone2; ?>" 
                                                           pattern="[0-9\s]{8,15}"
                                                           autocomplete="off">
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12 text-center">
                                                    <button type="submit" class="btn btn-sm btn-second btn-raised">Actualizar</button>
                                                </div>
                                            </div>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                            <h3>No have tutor</h3>
                                        <?php endif ?>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="update_info">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="data-box">
                                    <h4>Datos Academicos</h4>
                                    <form action="<?= Config::get('URL'); ?>alumno/actualizarDatosAcademicos" method="POST" class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-6"><small>Ocupación:</small>
                                                <input type="hidden" name="alumno" value="<?= $alumno->id; ?>">
                                                <select class="form-control" name="ocupacion">
                                                    <option <?= $alumno->ocupation == 'Estudiante' ? 'selected' : ''; ?> value="Estudiante">Estudio</option>
                                                    <option <?= $alumno->ocupation == 'Trabajador' ? 'selected' : ''; ?> value="Trabajador">Trabajo</option>
                                                    <option <?= $alumno->ocupation == 'Ninguno' ? 'selected' : ''; ?> value="Ninguno">Ninguno</option>
                                                </select>
                                            </label>
                                            <label class="col-sm-6"><small>Lugar de Trabajo/Estudio:</small> 
                                                <input type="tel" 
                                                       class="form-control"  
                                                       name="lugar_trabajo" 
                                                       value="<?= $alumno->workplace; ?>">
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6"><small>Nivel de Estudios:</small> 
                                                <select class="form-control" id="nivel" name="nivel_estudio">
                                                    <option value="">Seleccione...</option>
                                                    <option <?= $alumno->study == 'Preescolar' ? 'selected' : ''; ?> value="Preescolar">Preescolar</option>
                                                    <option <?= $alumno->study == 'Primaria' ? 'selected' : ''; ?> value="Primaria">Primaria</option>
                                                    <option <?= $alumno->study == 'Secundaria' ? 'selected' : ''; ?> value="Secundaria">Secundaria</option>
                                                    <option <?= $alumno->study == 'Bachillerato' ? 'selected' : ''; ?> value="Bachillerato">Bachillerato</option>
                                                    <option <?= $alumno->study == 'Licenciatura' ? 'selected' : ''; ?> value="Licenciatura">Licenciatura</option>
                                                </select>
                                            </label>
                                            <label class="col-sm-6"><small>ültimo Grado Estudio:</small> 
                                                <select class="form-control" name="grado_estudio">
                                                    <option value="">Seleccione...</option>
                                                    <option <?= $alumno->grade == 'Primer Año' ? 'selected' : ''; ?> value="Primer Año">Primer Año.</option>
                                                    <option <?= $alumno->grade == 'Segundo Año' ? 'selected' : ''; ?> value="Segundo Año">Segundo Año.</option>
                                                    <option <?= $alumno->grade == 'Tercer Año' ? 'selected' : ''; ?> value="Tercer Año">Tercer Año.</option>
                                                    <option <?= $alumno->grade == 'Cuarto Año' ? 'selected' : ''; ?> value="Cuarto Año">Cuarto Año.</option>
                                                    <option <?= $alumno->grade == 'Quinto Año' ? 'selected' : ''; ?> value="Quinto Año">Quinto Año.</option>
                                                    <option <?= $alumno->grade == 'Sexto Año' ? 'selected' : ''; ?> value="Sexto Año">Sexto Año.</option>
                                                    <option <?= $alumno->grade == 'Concluido' ? 'selected' : ''; ?> value="Concluido">Concluido.</option>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12 text-center">
                                                <button type="submit" class="btn btn-sm btn-second btn-raised">Actualizar</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="update_map">
                            <div class="row">
                                <div class="col-md-12">
                                <input type="button"
                                       id="btn_marker" 
                                       value="Marcar" 
                                       onclick="addMarkerAtCenter()" 
                                       class="btn btn-info btn-sm" />
                                </div>
                                <div class="col-md-12">
                                    <div class="coordinates">
                                        <?php foreach ($alumno->address as $address): ?>
                                        <input type="hidden" 
                                               id="lat" 
                                               name="lat"
                                               value="<?= $address->latitud; ?>" 
                                               class="form-control" 
                                               onclick="select()" />
                                        <input type="hidden" 
                                               id="lng" 
                                               name="lng"
                                               value="<?= $address->longitud; ?>" 
                                               class="form-control" 
                                               onclick="select()" />
                                        <?php endforeach ?>
                                    </div>
                                    <div id="map">
                                        <div id="map_canvas"></div>
                                        <div id="crosshair">
                                            <span class="glyphicon glyphicon-move"></span>
                                        </div>
                                        <span id="zoom_level"></span>
                                    </div>
                                    <div class="address">
                                        <span id="formatedAddress">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach ?>
        <?php endif ?>
        </div>
    </div>
</div>

<span data-toggle=snackbar
      data-content=""
      data-timeout="3200"
      data-html-allowed="true"
      id="student_snack">
</span>

<div id="checkout" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header modal-delete">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Dar de Baja</h4>
            </div>
            <div class="modal-body">
                <p class="text-center"> Dara de baja a:<br> <strong id="student_name"></strong>. <br> 
                                        ¿Desea continuar con esta acción?
                </p>
                <input type="hidden" id="alumno_id">
            </div>
            <div class="row">
                <div class="modal-footer col-sm-10 col-sm-offset-1 text-center">
                    <button type="button" id="no_checkout" class="btn btn-sm btn-gray btn-raised left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="checkout_student" class="btn btn-sm btn-danger btn-raised right">Dar de Baja</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="checkin" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
                <h4 class="modal-title text-center">Dar de Alta</h4>
            </div>
            <div class="modal-body">
                <p class="text-center"> Dara de alta a:<br> <strong id="alumno_name"></strong>. <br> 
                                        ¿Desea continuar con esta acción?
                </p>
                <input type="hidden" id="id_alumno">
            </div>
            <div class="row">
                <div class="modal-footer col-sm-10 col-sm-offset-1 text-center">
                    <button type="button" id="no_checkin" class="btn btn-sm btn-gray btn-raised left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="checkin_student" class="btn btn-sm btn-second btn-raised right">Dar de Alta</button>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADKOI0m49Qp3bAb_lZt66MhZA2OMgM3lQ"></script>
<!-- <script src="<?php //echo Config::get('URL'); ?>assets/js/mapa.js"></script>
<script>
  $(document).ready(function(){
      init_map();
    });
</script> -->