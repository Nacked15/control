<a class='btn btn-naatik btn-sm btn-raised btn-tiny cancel_new right' title='Volver'>
    Cerrar &nbsp;<i class="glyphicon glyphicon-remove"></i>
</a>
<h4 class="text-center text-info">Crear Nueva Clase</h4>

<form action="<?php echo Config::get('URL');?>curso/nuevaClase" method="POST" class="form-horizontal">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="inputname" class="col-sm-4" >Curso: </label>
                <div class="col-xs-8 col-sm-8">
                    <select class="form-control"  name="curso" required="true">
                        <option value="">Seleccione...</option>
                        <?php  
                        if ($this->cursos) {
                            foreach ($this->cursos as $curso) {
                                echo '<option value="'.$curso->id.'">'.$curso->name.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="inputname" class="col-xs-4 col-sm-4 control-label">Grupo: </label>
                <div class="col-xs-8 col-sm-8">
                    <select class="form-control" id="" name="grupo" required="true">
                        <option value="">Seleccione...</option>
                        <?php  
                        if ($this->niveles) {
                            foreach ($this->niveles as $nivel) {
                                echo '<option value="'.$nivel->id.'">'.$nivel->level.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="f_inicio" class="col-sm-4">Fecha de Inicio: </label>
                <div class="col-sm-8">
                    <input type="text" 
                           id="date_init" 
                           class="form-control"
                           placeholder="Inicia.." 
                           name="f_inicio" required>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="f_fin" class="col-sm-4 control-label">Fecha Fin: </label>
                <div class="col-sm-8">
                    <input type="text" 
                           id="date_end" 
                           class="form-control"
                           placeholder="Finaliza.." 
                           name="f_fin" required>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="periodo" class="col-sm-4">Periodo: </label>
                <div class="col-sm-8">
                    <select class="form-control" name="ciclo" required="true">
                       <?php date("Y"); $anioAnt=date("Y")-1; $anioNext=date("Y")+1; ?>
                       <option value="">Seleccione...</option>
                       <option value="<?= $anioNext;?> A"><?php echo $anioNext; ?> A</option>
                       <option value="<?= $anioNext;?> B"><?php echo $anioNext; ?> B</option>
                       <option value="<?= date('Y');?> A"><?php echo date("Y"); ?> A</option>
                       <option value="<?= date('Y');?> B"><?php echo date("Y"); ?> B</option>
                       <option value="<?= $anioAnt;?> A"><?php echo $anioAnt; ?> A</option>
                       <option value="<?= $anioAnt;?> B"><?php echo $anioAnt; ?> B</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="dias" class="col-sm-4 control-label">Dias: </label>
                <div class="col-sm-8">
                    <select name="dias[]" id="dias" style="width: 100%;" class="form-control" multiple>
                        <?php  
                        if ($this->dias) {
                            foreach ($this->dias as $dia) {
                                echo '<option value="'.$dia->id.'">'.$dia->day.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
               <label for="h_inicio" class="col-md-4">Hora de Inicio: </label>
               <div class="col-md-8 bootstrap-timepicker">
                  <input type="text"
                         id="timepick" 
                         name="h_inicio" 
                         class="form-control" 
                         placeholder="2:00" 
                         required>
               </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
               <label for="h_salida" class="col-md-4 control-label">Hora Salida: </label>
               <div class="col-md-8 bootstrap-timepicker">
                  <input type="text"
                         id="timepick2"
                         name="h_salida" 
                         class="form-control" 
                         placeholder="2:00" required>
               </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6">
            <div class="form-group">
               <label class="col-md-4">Costo Inscripción: </label>
               <div class="col-md-8">
                  <input type="text" 
                         class="form-control" 
                         name="inscripcion" 
                         id="inscripcion" 
                         placeholder="200">
               </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
               <label for="h_salida" class="col-md-4 control-label">Maestro: </label>
               <div class="col-md-8">
                  <select class="form-control" id="" name="maestro">
                        <option value="">Seleccione...</option>
                        <?php  
                        if ($this->maestros) {
                            foreach ($this->maestros as $maestro) {
                                echo '<option value="'.$maestro->user_id.'">
                                        '.$maestro->name.' '.$maestro->lastname.'
                                      </option>';
                            }
                        }
                        ?>
                    </select>
               </div>
            </div>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12 text-center">
            <!-- <input type="button" class="btn btn-md btn-raised btn-gray left cancel_new" value="CANCELAR"> -->
            <input type="submit"  class="btn btn-md btn-raised btn-primary" value="CREAR">
        </div>
    </div><br>
</form>