<?php $base_url = Config::get('URL'); ?>
<div class="container">
    <ol class="breadcrumb">
        <li><a href="<?= $base_url; ?>dashboard">Principal</a></li>
        <li><a href="<?= $base_url; ?>alumno">Alumnos</a></li>
        <li><a href="javascript:void(0)" class="active">Nuevo Alumno</a></li>
    </ol>    
    <!-- <div class="well"> -->
    <div class="bs-component">
        <input type="hidden" id="viewActive" value="<?= $this->activeView; ?>">
        <ul class="nav nav-tabs nav-justified nav-submenu menu_nuevo_alumno" style="margin-bottom: 15px;">
            <li class="info_tutor" data-index="info_tutor">
                <a href="#tutor" data-toggle="tab">TUTOR</a>
            </li>
            <li class="info_student" data-index="info_student">
                <a href="#student" data-toggle="tab">ALUMNO</a>
            </li>
            <li class="info_academic" data-index="info_academic">
                <a href="#studies" data-toggle="tab">ESTUDIOS</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content well well-content">
            <?php $this->renderFeedbackMessages(); $_url = Config::get('URL'); ?>
            <div class="tab-pane info_tutor fade in" id="tutor">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form action="<?= $_url; ?>alumno/guardarDatosTutor" method="POST" class="form-horizontal" accept-charset='utf-8'>
                        <legend><h4 class="bg-info text-center">DATOS DEL TUTOR: </h4></legend>
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                            <div class="form-group">
                                <label class="col-md-5 control-label">¿Tiene Tutor?: </label>
                                <div class="col-md-7">
                                    <div class="radio radio-info">
                                        <label>SI
                                           <input type="radio" 
                                                  id="tutor_yes" 
                                                  value="si" 
                                                  checked="checked" 
                                                  name="hasTutor">
                                           <span class="circle"></span>
                                           <span class="check"></span>
                                        </label>
                                        <label for=""></label>
                                        <label>NO
                                           <input type="radio" 
                                                  id="tutor_not" 
                                                  value="no" 
                                                  name="hasTutor">
                                           <span class="circle"></span>
                                           <span class="check"></span>                                       
                                        </label>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div id="info_tutor">
                            <div class="row">
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input type="text" 
                                                   class="form-control text-center" 
                                                   id="apellido_pat" 
                                                   name="apellido_pat"
                                                   pattern="[a-zA-Z\s]{3,60}" 
                                                   placeholder="Apellido Paterno" 
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input type="text" 
                                                   class="form-control text-center" 
                                                   id="apellido_mat" 
                                                   name="apellido_mat"
                                                   pattern="[a-zA-Z\s]{3,60}" 
                                                   placeholder="Apellido Materno" 
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                          <input type="text" 
                                                 class="form-control text-center" 
                                                 id="nombre_tutor" 
                                                 name="nombre_tutor"
                                                 pattern="[a-zA-Z\s]{3,80}"
                                                 placeholder="Nombre" 
                                                 autocomplete="off">
                                            <input type="hidden" class="form-control" id="tutor_id" 
                                                   name="tutor_id">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <div id="exist_tutor" class="text-center"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="parentesco" class="col-sm-4 control-label">Parentesco: </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="parentesco" name="parentesco">
                                                <option value="">Seleccione...</option>
                                                <option value="Madre">Madre</option>
                                                <option value="Padre">Padre</option>
                                                <option value="Abuelo(a)">Abuelo(a)</option>
                                                <option value="Hermano(a)">Hermano(a)</option>
                                                <option value="Tio(a)">Tío(a)</option>
                                                <option value="Tutor">Tutor</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ocupacion" class="col-sm-4 control-label">Ocupación: </label>
                                        <div class="col-sm-8">
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="ocupacion" 
                                                   name="ocupacion"
                                                   pattern="[a-zA-Z\s]{3,80}"
                                                   placeholder="Trabajo como.." 
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                  
                                    <div class="form-group">
                                        <label for="telcel" class="col-sm-4 control-label">Tel. Celular: </label>
                                        <div class="col-sm-8">
                                            <input type="tel" 
                                                   class="form-control" 
                                                   id="tel_celular" 
                                                   name="tel_celular" 
                                                   placeholder="983 100 1020"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputtel" class="col-sm-4 control-label">Tel. Casa: </label>
                                        <div class="col-sm-8">
                                            <input type="tel" 
                                                   class="form-control" 
                                                   id="tel_casa" 
                                                   name="tel_casa" 
                                                   placeholder="83 100 1122" 
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Tel. Alternativo:</label>
                                        <div class="col-md-8">
                                            <input type="tel" 
                                                   class="form-control"
                                                   id="tel_alterno"
                                                   name="tel_alterno" 
                                                   placeholder="983 000 1122" 
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Parentesco:</label>
                                        <div class="col-md-8">
                                            <select class="form-control" id="parent_alt" name="parentesco_alterno">
                                                <option value="">Seleccione...</option>
                                                <option value="Madre">Madre</option>
                                                <option value="Padre">Padre</option>
                                                <option value="Abuelo(a)">Abuelo(a)</option>
                                                <option value="Hermano(a)">Hermano(a)</option>
                                                <option value="Hermano(a)">Tío(a)</option>
                                                <option value="Tutor">Tutor</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="form-group row" style="border: 1px solid #ccc;border-radius:2px; padding: 5px;">
                                    <label for="inpudir" class="control-label">Direccion: </label><br>
                                    <div class="col-sm-3">
                                        <input type="text" 
                                               class="form-control" 
                                               id="street" 
                                               name="calle" 
                                               placeholder="Calle" 
                                               autocomplete="off">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" 
                                               class="form-control" 
                                               id="number" 
                                               name="numero" 
                                               placeholder="Numero" 
                                               autocomplete="off">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" 
                                               class="form-control" 
                                               id="between" 
                                               name="entre" 
                                               placeholder="Entre" 
                                               autocomplete="off">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" 
                                               class="form-control" 
                                               id="colony" 
                                               name="colonia" 
                                               placeholder="Colonia" 
                                               autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-center text-info" id="continue"></p>
                        <br>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <input type="button"
                                       id="btn_marker" 
                                       value="Marcar Ubicación" 
                                       onclick="addMarkerAtCenter()" 
                                       class="btn btn-success btn-sm" />
                            </div>
                            <div class="col-md-12">
                                <div class="coordinates">
                                    <input type="hidden" 
                                           id="lat" 
                                           name="lat"
                                           value="19.579994462915835" 
                                           class="form-control" 
                                           onclick="select()" />
                                    <input type="hidden" 
                                           id="lng" 
                                           name="lng"
                                           value="-88.04420235898436" 
                                           class="form-control" 
                                           onclick="select()" />
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
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-4 text-center">
                            <br>
                            <input type="submit" class="btn btn-md btn-raised btn-second" value="GUARDAR" />
                            <br><br><br>
                            </div>
                        </div>
                        </form>
                    </div>    
                </div>
            </div>
            <div class="tab-pane info_student fade in" id="student">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                    <form action="<?php echo Config::get('URL'); ?>alumno/guardarDatosAlumno" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        <legend><h4 class="bg-info text-center">DATOS DEL ALUMNO: </h4></legend>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                       <input type="text" 
                                              class="form-control text-center" 
                                              id="surname" 
                                              name="surname" 
                                              placeholder="Apellido Paterno"
                                              pattern="[a-zA-Z\s]{2,60}" 
                                              autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="text" 
                                              class="form-control text-center" 
                                              id="lastname" 
                                              name="lastname" 
                                              placeholder="Apellido Materno"
                                              pattern="[a-zA-Z\s]{2,60}" 
                                              autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="text" 
                                               class="form-control text-center" 
                                               id="name" 
                                               name="name" 
                                               placeholder="Nombre(s)"
                                               pattern="[a-zA-Z\s]{3,60}" 
                                               autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <div id="exist_student" class="text-center"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="dia" class="col-md-3 control-label">Cumpleaños:</label>
                                    <div class="col-md-3">
                                        <select class="form-control" name="day" required="true">
                                            <option value="">Día...</option>
                                            <?php 
                                            for ($j=1; $j<=31; $j++){
                                                echo "<option value='".$j."'>".$j."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="month" required="true">
                                            <option value="">Mes...</option>
                                            <option value="01">Enero</option>
                                            <option value="02">Febrero</option>
                                            <option value="03">Marzo</option>
                                            <option value="04">Abril</option>
                                            <option value="05">Mayo</option>
                                            <option value="06">Junio</option>
                                            <option value="07">Julio</option>
                                            <option value="08">Agosto</option>
                                            <option value="09">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="year" required="true">
                                            <option value="">Año...</option>
                                            <?php 
                                                $thisYear = date("Y")-3;
                                                $lastYear = $thisYear - 60;
                                                for ($i=$thisYear; $i>=$lastYear; $i--){
                                                    echo "<option value='".$i."'>".$i."</option> ";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="genero" class="col-sm-4 control-label">Sexo: </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="genero">
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="edo_civil" class="col-sm-4 control-label">Estado Civil: </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="edo_civil">
                                            <option value="Soltero(a)">Soltero(a)</option>
                                            <option value="Casado(a)">Casado(a)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="celular" class="col-sm-3 control-label">Num. celular: </label>
                                    <div class="col-sm-9">
                                        <input type="tel" 
                                               class="form-control" 
                                               id="celular" 
                                               name="celular" 
                                               placeholder="983 100 1020" 
                                               pattern="[0-9\s]{8,15}" 
                                               autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11 col-sm-offset-1">
                            <div class="form-group" 
                                 style="border: 1px solid #ccc;border-radius:2px; padding: 5px;">
                                <label for="inpudir" class="control-label">Direccion: </label><br>
                                <div class="col-sm-3">
                                    <input type="text" 
                                           class="form-control" 
                                           id="street_s" 
                                           name="calle"
                                           <?= $this->street ? 'value="'.$this->street.'"' : ''; ?>
                                           placeholder="Calle" 
                                           autocomplete="off">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" 
                                           class="form-control" 
                                           id="number_s" 
                                           name="numero"
                                           <?= $this->number ? 'value="'.$this->number.'"' : ''; ?>
                                           placeholder="Numero" 
                                           autocomplete="off">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" 
                                           class="form-control" 
                                           id="between_s" 
                                           name="entre"
                                           <?= $this->between ? 'value="'.$this->between.'"' : ''; ?>
                                           placeholder="Entre" 
                                           autocomplete="off">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" 
                                           class="form-control" 
                                           id="colony_s" 
                                           name="colonia"
                                           <?= $this->colony ? 'value="'.$this->colony.'"' : ''; ?>
                                           placeholder="Colonia" 
                                           autocomplete="off">
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Referencia:</label>
                                    <div class="col-sm-10">
                                        <input type="text" 
                                               class="form-control" 
                                               id="referencia" 
                                               name="referencia" 
                                               placeholder="Indique una referencia del domicilio" 
                                               autocomplete="off">
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">¿Padece alguna enfermedad?: </label>
                                    <div class="col-sm-5">
                                        <div class="radio radio-info">
                                            <label>NO
                                                <input type="radio" 
                                                       id="isSick_not" 
                                                       value="No" 
                                                       name="isSickness" 
                                                       checked="checked">
                                                <span class="circle"></span>
                                                <span class="check"></span>                                       
                                            </label>
                                            <label for=""></label>
                                            <label>SI
                                                <input type="radio" id="isSick_yes" value="Si" name="isSickness">
                                                <span class="circle"></span>
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group sicknes_detail">
                                    <label class="col-sm-3 control-label">¿Especifique Cuál?: </label>
                                    <div class="col-sm-8">
                                        <input type="text" 
                                              class="form-control" 
                                              id="padecimiento" 
                                              name="padecimiento" 
                                              placeholder="Especifique de que padece" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group sicknes_detail">
                                    <label class="col-sm-3 control-label">¿Indique tratamiento?: </label>
                                    <div class="col-sm-8">
                                        <input type="text" 
                                              class="form-control" 
                                              id="tratamiento" 
                                              name="tratamiento" 
                                              placeholder="¿Qué hacer en dado caso?" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">¿Es de familia Homestay?: </label>
                                    <div class="col-sm-5">
                                        <div class="radio radio-info">
                                            <label> No
                                                <input type="radio" checked="checked" value="0" name="homestay">
                                                <span class="circle"></span><span class="check"></span>
                                            </label>
                                            <label></label>
                                            <label> SI
                                                <input type="radio" value="1" name="homestay">
                                                <span class="circle"></span><span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">¿Entregó acta de nacimiento?: </label>
                                    <div class="col-sm-5">
                                        <div class="radio radio-info">
                                            <label> No
                                                <input type="radio" checked="checked" value="0" name="acta">
                                                <span class="circle"></span><span class="check"></span>
                                            </label>
                                            <label></label>
                                            <label> SI
                                                <input type="radio" value="1" name="acta">
                                                <span class="circle"></span><span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">¿Requiere facturaci&oacute;n?: </label>
                                    <div class="col-sm-5">
                                        <div class="radio radio-info">
                                            <label> No
                                                <input type="radio" checked="checked" value="0" name="facturacion">
                                                <span class="circle"></span><span class="check"></span>
                                            </label>
                                            <label></label>
                                            <label> SI
                                                <input type="radio" value="1" name="facturacion">
                                                <span class="circle"></span><span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Subir Foto:</label>
                                    <div class="col-sm-9">
                                        <input type="file" id="avatar" name="avatar_file" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Comentario:</label>
                                    <div class="col-sm-9">
                                        <textarea name="comentario" 
                                                  class="form-control"
                                                  placeholder="Escriba aquí alguna observación sobre el alumno..." 
                                                  rows="4" 
                                                  style="border: 1px solid #eee;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-4 text-center">
                                <br>
                                <input type="submit" class="btn btn-md btn-raised btn-second" value="GUARDAR">
                                <br>
                                <br>
                                <br>
                            </div>
                        </div>
                    </form>  
                    </div>
                </div>
            </div>
            <div class="tab-pane info_academic fade in" id="studies">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                    <form action="<?php echo Config::get('URL'); ?>alumno/guardarDatosAcademicos" method="post" class="form-horizontal">   
                        <legend><h4 class="bg-info text-center">ANTECEDENTES: </h4></legend>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ocupacion" class="col-sm-4">Ocupación: </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="ocupation" name="ocupacion">
                                            <option value="Ninguno">Seleccione..</option>
                                            <option value="Estudiante">Estudio</option>
                                            <option value="Trabajador">Trabajo</option>
                                            <option value="Ninguno">Ninguno</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="job" class="form-group">
                                    <label for="lugar" class="col-sm-4 control-label" id="workplace">Donde: </label>
                                    <div class="col-sm-8">
                                        <input type="text" 
                                               class="form-control" 
                                               id="lugar_trabajo" 
                                               name="lugar_trabajo" 
                                               placeholder="Lugar de trabajo/estudio">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">          
                                <div class="form-group">
                                    <label for="nivel" class="col-sm-4">Nivel de estudios: </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="nivel" name="nivel_estudio">
                                            <option value="">Seleccione...</option>
                                            <option value="Preescolar">Preescolar</option>
                                            <option value="Primaria">Primaria</option>
                                            <option value="Secundaria">Secundaria</option>
                                            <option value="Bachillerato">Bachillerato</option>
                                            <option value="Licenciatura">Licenciatura</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" id="grados">
                                <div class="form-group grade">
                                    <label for="grado" class="col-sm-4 control-label">Grado: </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="grado_estudio">
                                            <option value="">Seleccione...</option>
                                            <option value="Primer Año">Primer Año.</option>
                                            <option value="Segundo Año">Segundo Año.</option>
                                            <option value="Tercer Año">Tercer Año.</option>
                                            <option class="extra" value="Cuarto Año">Cuarto Año.</option>
                                            <option class="extra" value="Quinto Año">Quinto Año.</option>
                                            <option class="extra" value="Sexto Año">Sexto Año.</option>
                                            <option value="Concluido">Concluido.</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="curso_previo" class="col-sm-4">
                                        ¿Tomó algún curso de inglés previamente?: 
                                    </label>
                                    <div class="col-sm-5">
                                        <div class="radio radio-info">
                                        <label> No
                                            <input type="radio" 
                                                   id="optionNo" 
                                                   checked="checked" 
                                                   value="0" 
                                                   name="curso_previo">
                                            <span class="circle"></span><span class="check"></span>
                                        </label>
                                        <label></label>
                                        <label> SI
                                            <input type="radio" 
                                                   id="optionSi" 
                                                   value="1" 
                                                   name="curso_previo">
                                            <span class="circle"></span><span class="check"></span>
                                        </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" id="describa">
                                <div class="form-group">
                                    <label class="col-sm-2">Describa: </label>
                                    <div class="col-sm-10">
                                        <input type="text" 
                                               class="form-control" 
                                               id="cursoanterior" 
                                               name="description_previo" 
                                               placeholder="Descripcion de cursos anteriores">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <legend><h4 class="bg-info text-center">CURSO A TOMAR:</h4></legend> 

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Curso: </label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="course" name="curso" required>
                                            <option value="">Seleccione...</option>
                                            <?php  
                                            if ($this->cursos) {
                                                foreach ($this->cursos as $curso) {
                                                    echo '<option value="'.$curso->course_id.'">'.$curso->course.'</option>';
                                                }
                                            } else {
                                                echo '<option>No hay cursos registrados</option>';
                                            }
                                            ?>
                                            <option value="0">Agregar Más Tarde</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Grupo: </label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="groupList" name="grupo" required>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">Inicio Alumno:</label>
                                    <div class="col-sm-7">
                                        <input type="text" 
                                               id="fecha_inicio" 
                                               class="form-control"
                                               placeholder="Cuándo inicia el alumno" 
                                               name="f_inicio_alumno">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="datosClase">
                            <div id="clasedata" class="col-sm-8 col-sm-offset-1">
                                <div class="form-group">
                                    <span class="col-sm-6" id="clase_name"></span>
                                    <span class="col-sm-6" id="f_inicio"></span>
                                    <div class="clearfix"></div>
                                    <span class="col-sm-6" id="horario_c"></span>
                                    <span class="col-sm-6" id="f_fin"></span>
                                    <div class="clearfix"></div>
                                    <span class="col-sm-12" id="dias"></span>
                                </div>
                                <input type="hidden" name="clase" id="clase_id">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-4 text-center">
                                <br>
                                <input type="submit" class="btn btn-md btn-raised btn-second" value="GUARDAR">
                                <br><br><br>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADKOI0m49Qp3bAb_lZt66MhZA2OMgM3lQ"></script> -->