<div class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <ol class="breadcrumb">
                <li><a href="<?= Config::get('URL'); ?>dashboard">Principal</a></li>
                <li><a href="<?= Config::get('URL'); ?>alumno">Alumnos</a></li>
                <li><a href="javascript:void(0)" class="active">Convenio</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="well">
                <div class="row">
                    <div class="col-sm-1 text-center">
                        <img src="<?= Config::get('URL');?>public/assets/img/loading.gif" alt="logo" width="60" height="60">
                    </div>
                    <div class="col-sm-11 text-center conv_header">
                        <h4><strong>-SCHOOL- S. C.</strong></h4>
                        <p>"-SCHOOL- TE ABRE LAS PUERTAS AL MUNDO"<br>
                            Calle 57 entre 78 y 80, Col. Francisco May, Quintana Roo. <br>
                            Teléfonos: Esc. 1 23 4567, Cel Directora. 913-000-0000, Lic. Name Lastname, Directora.   
                        </p>
                    </div>
                    <div class="divider"></div>
                    <div class="clearfix"></div>
                    <div class="col-sm-11 col-sm-offset-1 text-center">
                        <h5><strong>C O N V E N I O</strong></h5>
                    </div>
                    <div class="col-sm-12 conv_text text-justify">
                        <p>
                            CONVENIO DE INSCRIPCIÓN A CURSO DE INGLÉS QUE CELEBRAN POR UNA PARTE "-SCHOOL-" Y EL ALUMNO <u> Nombre ApellidoP ApellidoM </u> POR CONSIGUIENTE AMBAS PARTES ACUERDAN SOMETERSE AL TENOR DE LAS SIGUIENTES:
                        </p>
                    </div>
                    <div class="col-sm-11 col-sm-offset-1 text-center">
                        <h5><strong>C L  A U S U L A S</strong></h5><br>
                    </div>
                    <div class="col-sm-12 conv_text text-justify">
                        <p><strong>PRIMERA: </strong>
                            LA INSCRIPCIÓN SERÁ PARA ASISTIR A LAS CLASES DE <u>&nbsp;&nbsp; ADOLESCENTES INICIAL SABADO &nbsp;&nbsp;</u> CON &nbsp; INICIO EL DÍA <u>&nbsp; MIERCOLES 27 DE SEPTIEMBRE DEL AÑO 2017 &nbsp;</u>  EN HORARIO DE <u>&nbsp; 11:00 - 14:00 HRS </u>. LOS DÍAS <u> LUNES, MARTES, MIERCOLES &nbsp;</u> CON UNA DURACION DE <u>&nbsp; 10 &nbsp;</u> SEMANAS, LAS CLASES SE IMPARTIRÁN EN LAS INSTALACIONES DE -SCHOOL-
                        </p>
                    </div>

                    <div class="col-sm-12 conv_text text-justify">
                        <p><strong>SEGUNDA: </strong>
                            EL INSTITUTO SE COMPROMETE A PROPORCIONAR AL ALUMNO LAS CONDICIONES NECESARIAS PARA FAVORECER EL ADECUADO DESARROLLO DEL PROCESO ENSEÑANZA-APRENDIZAJE, DESTINANDO PARA ELLO INSTALACIONES Y PERSONAL A FIN A LOS PROPÓSITOS DE CADA CURSO.
                        </p>
                    </div>

                    <div class="col-sm-12 conv_text text-justify">
                        <p><strong>TERCERA: </strong>
                            SERÁ COMPROMISO DEL INSTITUTO EMITIR PERIODICAMENTE LAS CALIFICACIONES DE LOS MÓDULOS QUE EL ALUMNO VAYA CURSANDO; ASÍ COMO MANTENER INFORMADO AL TUTOR DE LA CONDUCTA, SITUACIÓN.
                        </p>
                    </div>

                    <div class="col-sm-12 conv_text text-justify">
                        <p><strong>CUARTA: </strong>
                            EL INSTITUTO SE RESERVA EL DERECHO DE ADMISIÓN, QUEDANDO RESTRINGIDO EL USO DE EQUIPO Y ACCESO A LAS INSTALACIONES A TODA PERSONA QUE NO ACREDITE SU IDENTIDAD CON CREDENCIAL DE ESTE PLANTEL O CUANDO EL ALUMNO TENGA COMPROMISOS ECONÓMICOS PENDIENTES POR CUBRIR.
                        </p>
                    </div>

                    <div class="col-sm-12 conv_text text-justify">
                        <p><strong>QUINTA: </strong>
                            EL ALUMNO SE COMPROMETE A RESPETAR Y HACER RESPETAR EL REGLAMENTO INTERNO DEL INSTITUTO, Y POR CONSIGUIENTE ESTAR DE LAS FUSIONES DE GRUPO Y POSIBLES CAMBIOS DE HORARIO CUANDO EL NÚMERO DE ALUMNOS SEA REDUCIDO (MENOS DE SEIS ALUMNOS).
                        </p>
                    </div>

                    <div class="col-sm-12 conv_text text-justify">
                        <p><strong>SEXTA: </strong>
                            EL INSTITUTO RESPETARÁ LOS DÍAS DE SUSPENSIÓN DE LABORES MARCADOS EN EL CALENDARIO ESCOLAR DE LA SEP.
                        </p>
                    </div>


                    <div class="col-sm-12 conv_text">
                        <div class="row">
                            <div class="col-sm-4 text-center conv_sign">Escuela
                                <input type="text" name="school" class="form-control text-center" value="Control Escolar">
                            </div>
                            <div class="col-sm-4 text-center conv_sign">Tutor
                                <input type="text" name="tutor" class="form-control text-center" value="Apellido Apellido Nombre">
                            </div>
                            <div class="col-sm-4 text-center conv_sign">Alumno
                                <input type="text" name="tutor" class="form-control text-center" value="Apellido Apellido Nombre">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 conv_text text-center">
                        <a href="<?= Config::get('URL'); ?>alumno/conveniopdf" target="_blank" class="btn btn-sm btn-main btn-raised">Imprimir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>