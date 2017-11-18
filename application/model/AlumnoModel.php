<?php

class AlumnoModel
{
    public static function students($curso) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $alumnos = "SELECT s.student_id, s.id_tutor, s.name, s.surname,
                           s.lastname, s.age, s.genre, s.avatar, g.class_id,
                           g.convenio, sd.studies, sd.lastgrade
                    FROM students as s, students_groups as g, students_details as sd
                    WHERE s.status = 1
                      AND s.student_id = g.student_id
                      AND s.student_id = sd.student_id";

        switch ($curso) {
            case '1': //-> English club y big tots
                $alumnos .= ' AND (g.class_id = 1 OR g.class_id = 2) ORDER BY s.student_id ASC';
                break;
            case '2': //->primary
                $alumnos .= ' AND g.class_id = 3 ORDER BY s.student_id ASC';
                break;
            case '3': //->primary
                $alumnos .= ' AND g.class_id = 4 ORDER BY s.student_id ASC';
                break;
            case '4': //->adultos y avanzado
                $alumnos .= ' AND (g.class_id = 5 OR g.class_id = 6) ORDER BY s.student_id ASC';
                break;
            case '5': //->adultos y avanzado
                $alumnos .= ' AND g.class_id IS NULL ORDER BY s.student_id ASC';
                break;
            default:
                $alumnos .= ' ORDER BY s.student_id ASC';
                break;
        }
        $alumnos = $database->prepare($alumnos);
        $alumnos->execute();

        if ($alumnos->rowCount() > 0) {
            $alumnos = $alumnos->fetchAll();
            $datos = array();
            $count = 1;
            foreach ($alumnos as $alumno) {
                //-> Grupo del Alumno
                $id_grupo = 0;
                $grupo = '<a class="link add_to_group"
                             data-student="'.$alumno->student_id.'"
                             title="Agregar grupo"><strong>Agregar a Grupo</strong></a>';
                if ($alumno->class_id !== NULL) {
                    $clase = $database->prepare("SELECT c.class_id, c.course_id, cu.course, g.group_name
                                                 FROM classes as c, courses as cu, groups as g
                                                 WHERE c.class_id  = :clase
                                                   AND c.status    = 1
                                                   AND c.course_id = cu.course_id
                                                   AND c.group_id  = g.group_id
                                                 LIMIT 1;");
                    $clase->execute(array(':clase' => $alumno->class_id));
                    if ($clase->rowCount() > 0) {
                        $clase = $clase->fetch();
                        $id_grupo = $clase->class_id;
                        $grupo = '<a class="link change_group"
                                     data-student="'.$alumno->student_id.'"
                                     data-class="'.$clase->class_id.'"
                                     data-course="'.$clase->course_id.'"
                                     data-group="'.$clase->group_name.'"
                                     title="Agregar grupo">'.$clase->course.' '.$clase->group_name.'</a>';
                    }
                }

                //-> Tutor del Alumno
                $id_tutor     = 0;
                $nombre_tutor = '- - - -';
                if ($alumno->id_tutor !== NULL) {
                    $tutor = $database->prepare("SELECT id_tutor, namet, surnamet, lastnamet
                                                    FROM tutors
                                                    WHERE id_tutor = :tutor
                                                 LIMIT 1;");
                    $tutor->execute(array(':tutor' => $alumno->id_tutor));
                    if ($tutor->rowCount() > 0) {
                        $tutor = $tutor->fetch();
                        $id_tutor = $tutor->id_tutor;
                        $nombre_tutor = $tutor->namet.' '.$tutor->surnamet;
                    }
                }

                $datos[$count] = new stdClass();
                $datos[$count]->count    = $count;
                $datos[$count]->id       = $alumno->student_id;
                $datos[$count]->nombre   = $alumno->name;
                $datos[$count]->apellido = $alumno->surname.' '.$alumno->lastname;
                $datos[$count]->edad     = $alumno->age;
                $datos[$count]->sexo     = $alumno->genre;
                $datos[$count]->avatar   = $alumno->avatar;
                $datos[$count]->estudios = $alumno->studies.' '.$alumno->lastgrade;
                $datos[$count]->convenio = $alumno->convenio;
                $datos[$count]->id_grupo = $id_grupo;
                $datos[$count]->grupo    = $grupo;
                $datos[$count]->id_tutor = $id_tutor;
                $datos[$count]->tutor    = $nombre_tutor;
                $count++;
            }

            self::displayStudents($datos, $curso);
        } else {
            echo '<h4 class="text-center text-naatik subheader">No hay Alumnos inscritos en este nivel.</h4>';
        }
    }

    public static function displayStudents($alumnos, $curso){
        $u_type = Session::get('user_account_type');
        $show = $u_type === '1' || $u_type === '2'; //-> true or false
        if (count($alumnos) > 0) {
            $main_check =  '<div class="checkbox select_all"><label><span class="fa fa-arrow-up">
                                </span>
                                    <input type="checkbox" class="check_all" id="select_all_'.$curso.'" />
                                </label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            </div>';
            echo '<div class="table-responsive">';
                echo '<table id="tbl_students_'.$curso.'"
                             class="table table-bordered table-hover">';
                    echo '<thead>';
                        echo '<tr class="info">';
                            echo '<th class="text-center"> N° </th>';
                            echo '<th class="text-center">Foto</th>';
                            echo '<th class="text-center">Apellidos</th>';
                            echo '<th class="text-center">Nombre</th>';
                            echo '<th class="text-center">Escolaridad</th>';
                            echo '<th class="text-center">Edad</th>';
                            echo '<th class="text-center">Grupo</th>';
                            echo '<th class="text-center">Tutor</th>';
                            echo '<th class="text-center">Opciones</th>';
                        echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                        $c = 1;
                        foreach ($alumnos as $row) {
                            $r = $c < 10 ? '&nbsp;&nbsp;'.$c : $c;
                            $url = Config::get('URL').Config::get('PATH_AVATAR_STUDENT').$row->avatar;
                            $check = '<b>'.$r.'</b>';
                            $avatar = '<img class="foto-mini" src="'.$url.'.jpg" alt="avatar">';
                            $convenio = $row->convenio == "0" ?
                                            '<span data-toggle="tooltip" title="Convenio Pendiente" class="o-red fa fa-file-text-o"></span>' :
                                                '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                            if ($show) {
                            $check = '<div class="checkbox"><label><b>'.$r.'</b>
                                        <input type="checkbox" class="check_one" name="alumnos[]" value="'.$row->id.'" />
                                        </label>
                                        '.$convenio.'
                                      </div>';
                            }
                            echo '<tr class="row_data">';
                            echo '<td class="text-center">'.$check.'</td>';
                            echo '<td class="text-center">'.$avatar.'</td>';
                            echo '<td class="text-center txt">'.$row->apellido.'</td>';
                            echo '<td class="text-center txt">'.$row->nombre.'</td>';
                            echo '<td class="text-center txt">'.$row->estudios.'</td>';
                            echo '<td class="text-center txt">'.$row->edad.'</td>';
                            echo '<td class="text-center txt">'.$row->grupo.'</td>';
                            echo '<td class="text-center txt">'.$row->tutor.'</td>';
                            echo '<td class="text-center">';
                            echo '<div class="btn-group">';
                                echo '<a href="javascript:void(0)"
                                         data-target="#"
                                         class="btn btn-main btn-xs btn-raised dropdown-toggle"
                                         data-toggle="dropdown">Más.. &nbsp;&nbsp; <span class="caret"></span>
                                      </a>';
                                echo '<ul class="dropdown-menu student">';
                                if ($show) {
                                echo '<li>
                                            <a href="'.Config::get('URL').'alumno/perfilAlumno/'.$row->id.'"
                                               data-student="'.$row->id.'"
                                               data-tutor="'.$row->id_tutor.'"
                                               data-clase="'.$row->id_grupo.'"
                                               data-curso="'.$curso.'">
                                                <span class="o-blue glyphicon glyphicon-chevron-right"></span> Perfil</a>
                                        </li>';
                                echo    '<li><a href="'.Config::get('URL').'alumno/convenio">
                                            <span class="o-green glyphicon glyphicon-chevron-right"></span> Convenio</a></li>';
                                echo    '<li><a href="javascript:void(0)">
                                                <span class="o-purple glyphicon glyphicon-chevron-right"></span> Cambiar Foto
                                            </a>
                                        </li>';
                                }
                                echo   '<li><a href="'.Config::get('URL').'evaluaciones/index/'.$row->id.'">
                                            <span class="o-red glyphicon glyphicon-chevron-right"></span> Calificaciones</a>
                                        </li>';
                                echo '</ul>';
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                            $c++;
                        }
                    echo '</tbody>';
                    if ($u_type === '1' || $u_type === '2') {
                    echo '<tfoot>';
                    echo '<tr>';
                    echo '<td class="text-center">'.$main_check.'</td>';
                    echo '<td class="text-center">
                            <label class="label lbl_mini">Marcar</label>
                          </td>';
                    echo '<td class="text-center">
                            <button type="button" class="btn btn-xs mini btn-second change_multi">
                                Cambiar de Grupo</button>
                          </td>';
                    echo '<td class="text-center">
                            <button type="button" class="btn btn-xs mini btn-warning tekedown_multi">
                                Dar De Baja</button>
                          </td>';
                    echo '<td class="text-center">
                            <button type="button" class="btn btn-xs mini btn-danger delete_multi">
                                Eliminar</button>
                          </td>';
                    echo '<td class="text-center">
                          </td>';
                    echo '<td class="text-center">
                            <button type="button" class="btn btn-xs mini btn-green invoice_list">
                            Facturación</button>
                          </td>';
                    echo '</tr>';
                    echo '</tfoot>';
                    }
                echo '</table>';
                echo "<br><br><br>";
            echo '</div>';
        } else {
            echo '<h4 class="text-center text-naatik subheader">No hay Alumnos inscritos en este nivel.</h4>';
        }
    }

    public static function studentProfile($student){
        $database = DatabaseFactory::getFactory()->getConnection();
        $query = $database->prepare("SELECT *
                                     FROM students as s, students_groups as g, students_details as sd
                                     WHERE s.student_id = :student
                                       AND s.student_id = g.student_id
                                       AND s.student_id = sd.student_id
                                     LIMIT 1;");
        $query->execute(array(':student' => $student));

        if ($query->rowCount() > 0) {
            $info   = $query->fetch();
            $alumno = array();
            $address_owner = $info->student_id;
            $owner_type    = 2;

            $grupo = array();
            if ($info->class_id !== NULL) {
                $clase  =  "SELECT c.class_id, cu.course, g.group_name
                            FROM classes as c, courses as cu, groups as g
                            WHERE c.class_id  = :clase
                              AND c.course_id = cu.course_id
                              AND c.group_id  = g.group_id
                              AND c.status    = 1
                            LIMIT 1;";
                $clase = $database->prepare($clase);
                $clase->execute(array(':clase' => $info->class_id));
                if ($clase->rowCount() > 0) {
                    $clase = $clase->fetch();
                    $grupo[$clase->class_id] = new stdClass();
                    $grupo[$clase->class_id]->id    = $clase->class_id;
                    $grupo[$clase->class_id]->curso = ucwords(strtolower($clase->course));
                    $grupo[$clase->class_id]->grupo = ucwords(strtolower($clase->group_name));
                }
            }

            $datos_tutor = array();
            if ($info->id_tutor !== 0) {
                $tutor  =  "SELECT id_tutor, namet, surnamet, lastnamet,
                                   job, cellphone, phone, relationship,
                                   phone_alt, relationship_alt
                            FROM tutors
                            WHERE id_tutor = :tutor
                            LIMIT 1;";
                $tutor = $database->prepare($tutor);
                $tutor->execute(array(':tutor' => $info->id_tutor));

                if ($tutor->rowCount() > 0) {
                    $tutor = $tutor->fetch();

                    $datos_tutor[$tutor->id_tutor] = new stdClass();
                    $datos_tutor[$tutor->id_tutor]->id = $tutor->id_tutor;
                    $datos_tutor[$tutor->id_tutor]->name      = $tutor->namet;
                    $datos_tutor[$tutor->id_tutor]->surname   = $tutor->surnamet;
                    $datos_tutor[$tutor->id_tutor]->lastname  = $tutor->lastnamet;
                    $datos_tutor[$tutor->id_tutor]->job       = $tutor->job;
                    $datos_tutor[$tutor->id_tutor]->phone     = $tutor->phone;
                    $datos_tutor[$tutor->id_tutor]->cellphone = $tutor->cellphone;
                    $datos_tutor[$tutor->id_tutor]->relation  = $tutor->relationship;
                    $datos_tutor[$tutor->id_tutor]->phone2    = $tutor->phone_alt;
                    $datos_tutor[$tutor->id_tutor]->family    = $tutor->relationship_alt;

                    $address_owner = $tutor->id_tutor;
                    $owner_type    = 1;
                }
            }

            $address  = $database->prepare("SELECT * FROM address
                                            WHERE user_id = :user
                                              AND user_type = :type;");
            $address->execute(array(':user' => $address_owner, ':type' => $owner_type));
            $datos_address = array();
            if ($address->rowCount() > 0) {
                $address = $address->fetch();
                $datos_address[$address->id_address] = new stdClass();
                $datos_address[$address->id_address]->id      = $address->id_address;
                $datos_address[$address->id_address]->calle   = $address->street;
                $datos_address[$address->id_address]->numero  = $address->st_number;
                $datos_address[$address->id_address]->entre   = $address->st_between;
                $datos_address[$address->id_address]->colonia = $address->colony;
                $datos_address[$address->id_address]->ciudad  = $address->city;
                $datos_address[$address->id_address]->codigo  = $address->zipcode;
                $datos_address[$address->id_address]->estado  = $address->state;
                $datos_address[$address->id_address]->latitud = $address->latitud;
                $datos_address[$address->id_address]->longitud= $address->longitud;
            }

            $alumno[$info->student_id] = new stdClass();
            $alumno[$info->student_id]->id = $info->student_id;
            $alumno[$info->student_id]->id_tutor   = $info->id_tutor;
            $alumno[$info->student_id]->nombre     = $info->name;
            $alumno[$info->student_id]->ape_pat    = $info->surname;
            $alumno[$info->student_id]->ape_mat    = $info->lastname;
            $alumno[$info->student_id]->birthdate  = $info->birthday;
            $alumno[$info->student_id]->age        = $info->age;
            $alumno[$info->student_id]->genre      = $info->genre;
            $alumno[$info->student_id]->edo_civil  = $info->edo_civil;
            $alumno[$info->student_id]->cellphone  = $info->cellphone;
            $alumno[$info->student_id]->reference  = $info->reference;
            $alumno[$info->student_id]->sickness   = $info->sickness;
            $alumno[$info->student_id]->medication = $info->medication;
            $alumno[$info->student_id]->comment    = $info->comment_s;
            $alumno[$info->student_id]->status     = $info->status;
            $alumno[$info->student_id]->ocupation  = $info->ocupation;
            $alumno[$info->student_id]->workplace  = $info->workplace;
            $alumno[$info->student_id]->study      = $info->studies;
            $alumno[$info->student_id]->grade      = $info->lastgrade;
            $alumno[$info->student_id]->begun_at   = $info->date_begin;
            $alumno[$info->student_id]->convenio   = $info->convenio;
            $alumno[$info->student_id]->invoice    = $info->facturacion;
            $alumno[$info->student_id]->homestay   = $info->homestay;
            $alumno[$info->student_id]->acta       = $info->acta_nacimiento;
            $alumno[$info->student_id]->avatar     = $info->avatar;
            $alumno[$info->student_id]->clase     = $grupo;
            $alumno[$info->student_id]->tutor     = $datos_tutor;
            $alumno[$info->student_id]->address   = $datos_address;

            return $alumno;
        }
    }







    ///================= OLD
    public static function getStudents($curso = 1){
        $database = DatabaseFactory::getFactory()->getConnection();

        $u_type = Session::get('user_account_type');

        $sql = "SELECT s.*, c.id as clase, ad.studies, ad.last_grade, g.convenio,
                       cu.id as course, cu.name as curso, l.id as grupo, l.level
                FROM students as s,
                     academic_data as ad,
                     groups as g,
                     classes as c,
                     courses as cu,
                     levels as l
                WHERE s.student_id = ad.student_id
                  AND ad.baja      = 0
                  AND s.student_id = g.student_id
                  AND g.class_id   = c.id
                  AND c.status     = 1
                  AND c.id_course  = cu.id
                  AND c.id_level   = l.id ";

        if ($u_type === '3') {
            $teacher = Session::get('user_id');
            $sql .= ' AND c.id_teacher = '. $teacher .' ';
        }

        if ((int)$curso === 4 ) {
            $sql .= ' AND (cu.id = 5 OR cu.id = 6)';
            $query = $database->prepare($sql);
            $query->execute();
        } else if ((int)$curso === 1) {
            $sql .= ' AND (cu.id = 1 OR cu.id = 2)';
            $query = $database->prepare($sql);
            $query->execute();
        } else {
            $sql .= ' AND cu.id = :curso';
            $query = $database->prepare($sql);
            $query->execute(array(':curso' => $curso+1));
        }

        if ($query->rowCount() > 0) {
            $students = $query->fetchAll();

            $alumos = array();
            $id_tutor = 0;
            $tutor = '- - -';
            foreach ($students as $row) {
                if ($row->id_tutor !== '0') {
                    $getTutor = $database->prepare("SELECT id_tutor, namet, surname1, surname2
                                                    FROM tutors WHERE id_tutor = :tutor
                                                    LIMIT 1;");
                    $getTutor->execute(array(':tutor' => $row->id_tutor));
                    if ($getTutor->rowCount() > 0) {
                        $info = $getTutor->fetch();
                        $id_tutor = $info->id_tutor;
                        $tutor = ucwords(strtolower($info->namet)).' '.ucwords(strtolower($info->surname1));
                    }
                }

                $course = '<a class="link change_group"
                             data-student="'.$row->student_id.'"
                             data-group="'.$row->grupo.'"
                             data-course="'.$row->course.'"
                             data-clase="'.$row->clase.'"
                             title="Cambiar grupo">'.$row->curso.' '.$row->level.'</a>';

                $alumnos[$row->student_id] = new stdClass();
                $alumnos[$row->student_id]->id       = $row->student_id;
                $alumnos[$row->student_id]->name     = ucwords(strtolower($row->name));
                $alumnos[$row->student_id]->surname  = ucwords(strtolower($row->surname));
                $alumnos[$row->student_id]->lastname = ucwords(strtolower($row->lastname));
                $alumnos[$row->student_id]->avatar   = $row->avatar;
                $alumnos[$row->student_id]->tutor_id = $id_tutor;
                $alumnos[$row->student_id]->tutor    = $tutor;
                $alumnos[$row->student_id]->convenio = $row->convenio;
                $alumnos[$row->student_id]->birthdays = $row->birthday;
                $alumnos[$row->student_id]->age      = $row->age;
                $alumnos[$row->student_id]->genre    = $row->genre;
                $alumnos[$row->student_id]->clase    = $row->clase;
                $alumnos[$row->student_id]->course   = $course;
                $alumnos[$row->student_id]->study    = $row->studies;
                $alumnos[$row->student_id]->grade    = $row->last_grade;
            }
            self::displayStudents($alumnos, $curso);
        } else {
            echo '<h4 class="text-center text-naatik subheader">No hay Alumnos inscritos en este nivel.</h4>';
        }
    }

    public static function getStudentsAll($view){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT s.*, ad.studies, ad.last_grade, g.class_id, g.convenio
                FROM students as s,
                     academic_data as ad,
                     groups as g
                WHERE s.student_id = ad.student_id
                  AND ad.baja      = 0
                  AND s.student_id = g.student_id";

        if ($view === '5') {
            $sql .= ' AND g.class_id IS NOT NULL';
        } else {
            $sql .= ' AND g.class_id IS NULL';
        }

        $query = $database->prepare($sql);
        $query->execute();

        if ($query->rowCount() > 0) {
            $students = $query->fetchAll();

            $alumos = array();
            foreach ($students as $row) {
                $id_tutor = 0;
                $tutor = '- - -';
                $curso = '<a class="link adding_group"
                             data-student="'.$row->student_id.'"
                             data-toggle="modal"
                             data-target="#add_to_group"
                             title="Agregar grupo"><strong>Agregar a Grupo</strong></a>';
                $clase = 0;

                if ($row->id_tutor !== '0') {
                    $getTutor = $database->prepare("SELECT id_tutor, namet, surname1, surname2
                                                    FROM tutors WHERE id_tutor = :tutor
                                                    LIMIT 1;");
                    $getTutor->execute(array(':tutor' => $row->id_tutor));
                    if ($getTutor->rowCount() > 0) {
                        $info = $getTutor->fetch();
                        $id_tutor = $info->id_tutor;
                        $tutor = ucwords(strtolower($info->namet)).' '.ucwords(strtolower($info->surname1));
                    }
                }

                if ($row->class_id !== NULL) {
                    $qry = $database->prepare("SELECT c.id as clase,
                                                      cu.id as course,
                                                      l.id as grupo,
                                                      cu.name,
                                                      l.level
                                               FROM classes as c, courses as cu, levels as l
                                               WHERE c.id = :clase
                                                 AND c.id_course = cu.id
                                                 AND c.id_level  = l.id
                                               LIMIT 1;");
                    $qry->execute(array(':clase' => $row->class_id));

                    if ($qry->rowCount() > 0) {
                        $fila = $qry->fetch();
                        $clase = $fila->clase;
                        $curso = '<a class="link change_group"
                                     data-student="'.$row->student_id.'"
                                     data-group="'.$fila->grupo.'"
                                     data-course="'.$fila->course.'"
                                     data-clase="'.$fila->clase.'"
                                     title="Cambiar grupo">'.$fila->name.' '.$fila->level.'</a>';

                    }
                }

                $alumnos[$row->student_id] = new stdClass();
                $alumnos[$row->student_id]->id = $row->student_id;
                $alumnos[$row->student_id]->name      = ucwords(strtolower($row->name));
                $alumnos[$row->student_id]->surname   = ucwords(strtolower($row->surname));
                $alumnos[$row->student_id]->lastname  = ucwords(strtolower($row->lastname));
                $alumnos[$row->student_id]->avatar    = $row->avatar;
                $alumnos[$row->student_id]->tutor_id  = $id_tutor;
                $alumnos[$row->student_id]->tutor     = $tutor;
                $alumnos[$row->student_id]->birthdays = $row->birthday;
                $alumnos[$row->student_id]->convenio  = $row->convenio;
                $alumnos[$row->student_id]->age   = $row->age;
                $alumnos[$row->student_id]->genre = $row->genre;
                $alumnos[$row->student_id]->clase = $clase;
                $alumnos[$row->student_id]->course= $curso;
                $alumnos[$row->student_id]->study = $row->studies;
                $alumnos[$row->student_id]->grade = $row->last_grade;
            }
            self::displayStudents($alumnos, $view);
        } else {
            echo '<h4 class="text-center text-naatik subheader">No hay Alumnos para mostrar.</h4>';
            if ($view === '6') {
                echo '<h4 class="text-center text-info">Aquí se mostraran todos aquellos alumnos que no esten asignados a un grupo o clase.</h4><br><br>';
            }
        }
    }
    //=========================

    public static function getLevelsByClass($id) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT c.class_id, c.group_id, g.group_name
                FROM classes as c, groups as g
                WHERE c.course_id = :id
                  AND c.group_id  = g.group_id;";
        $query = $database->prepare($sql);
        $query->execute(array(':id' => $id));

        if($query->rowCount() > 0){
            return $query->fetchAll();
        }
    }

    public static function AddStudentToClass($alumno, $clase){
        $database = DatabaseFactory::getFactory()->getConnection();

        $update = $database->prepare("UPDATE groups SET class_id = :clase WHERE student_id = :alumno;");
        $update = $update->execute(array(':clase' => $clase, ':alumno' => $alumno));

        if ($update) {
            echo 1;
        } else {
            echo 0;
        }
    }

    //->Obtener Alumnos que requieren de factura tras pago de colegiatura
    public static function getStudentsInvoiceList(){
        $database = DatabaseFactory::getFactory()->getConnection();

        $getAlumnos = "SELECT s.student_id, s.name, s.surname, s.cellphone, s.id_tutor
                       FROM students as s, students_details as sd
                       WHERE s.student_id   = sd.id_student
                         AND sd.facturacion = 1;";
        $setAlumnos = $database->prepare($getAlumnos);
        $setAlumnos->execute();

        if ($setAlumnos->rowCount() > 0) {
            $alumnos = $setAlumnos->fetchAll();

            $students = array();
            foreach ($alumnos as $alumno) {
                $tutor  = '- - - -';
                $phone1 = '- - - -';
                $phone2 = '- - - -';
                $phone3 = '- - - -';

                if ($alumno->id_tutor !== '0') {
                    $getTutor = "SELECT namet, surname1, surname2, cellphone, phone, phone_alt
                                 FROM tutors
                                 WHERE id_tutor = :tutor
                                 LIMIT 1;";
                    $setTutor = $database->prepare($getTutor);
                    $setTutor->execute(array(':tutor' => $alumno->id_tutor));

                    if ($setTutor->rowCount() > 0) {
                        $datos  = $setTutor->fetch();
                        $tutor  = ucwords(strtolower($datos->namet)).' '.
                                  ucwords(strtolower($datos->surname1)).' '.
                                  ucwords(strtolower($datos->surname2));
                        $phone1 = $datos->cellphone != "" ? $datos->cellphone : ' - - - -';
                        $phone2 = $datos->phone != "" ? $datos->phone : ' - - - -';
                        $phone3 = $datos->phone_alt != "" ? $datos->phone_alt : ' - - - -';
                    }
                }

                $students[$alumno->student_id] = new stdClass();
                $students[$alumno->student_id]->name     = ucwords(strtolower($alumno->name)).' '.
                                                           ucwords(strtolower($alumno->surname));
                $students[$alumno->student_id]->cellphone = $alumno->cellphone;
                $students[$alumno->student_id]->tutor    = $tutor;
                $students[$alumno->student_id]->phone1   = $phone1;
                $students[$alumno->student_id]->phone2   = $phone2;
                $students[$alumno->student_id]->phone3   = $phone3;
            }
            self::showInvoiceList($students);
        } else {
            echo '<h4 class="text-center text-naatik subheader">Ningún alumno requiere facturación.</h4>';
        }
    }

    //->Mostrar Alumnos que requieren de factura tras pago de colegiatura
    public static function showInvoiceList($students) {
        if (count($students) > 0) {
            echo '<div class="table-responsive">';
                echo '<table id="tbl_invoice"
                             class="table table-bordered table-hover">';
                    echo '<thead>';
                        echo '<tr class="info">';
                            echo '<th class="text-center"> N° </th>';
                            echo '<th class="text-center">Alumno</th>';
                            echo '<th class="text-center">Celular</th>';
                            echo '<th class="text-center">Tutor</th>';
                            echo '<th class="text-center">Teléfono</th>';
                            echo '<th class="text-center">Celular</th>';
                            echo '<th class="text-center">Tel. Alterno</th>';
                        echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                        $c = 1;
                        foreach ($students as $row) {
                            echo '<tr class="row_data">';
                            echo '<td class="text-center">'.$c.'</td>';
                                echo '<td class="text-center txt">'.$row->name.'</td>';
                                echo '<td class="text-center txt">'.$row->cellphone.'</td>';
                                echo '<td class="text-center txt">'.$row->tutor.'</td>';
                                echo '<td class="text-center txt">'.$row->phone1.'</td>';
                                echo '<td class="text-center txt">'.$row->phone2.'</td>';
                                echo '<td class="text-center txt">'.$row->phone3.'</td>';
                            echo '</tr>';
                            $c++;
                        }
                    echo '</tbody>';
                echo '</table>';
                echo "<br><br><br>";
            echo '</div>';
        }
    }

    public static function ChangeStudentGroup($alumno, $clase){
        $database = DatabaseFactory::getFactory()->getConnection();

        $clase === '0' ? $clase = NULL : $clase = (int)$clase;
        $change = $database->prepare("UPDATE students_groups SET class_id = :clase WHERE student_id = :alumno;");
        $save = $change->execute(array(':clase' => $clase, ':alumno' => $alumno));
        if ($save) {
            echo 1;
        } else {
            echo 2;
        }

    }

    public static function ChangeStudentsGroup($alumnos, $clase){
        $database = DatabaseFactory::getFactory()->getConnection();

        $clase === '0' ? $clase = NULL : $clase = (int)$clase;
        $count = 0;
        foreach ($alumnos as $alumno) {
            $change = $database->prepare("UPDATE students_groups SET class_id = :clase WHERE student_id = :alumno;");
            $save = $change->execute(array(':clase' => $clase, ':alumno' => $alumno));
            if (!$save) {
                $count++;
            }
        }

        echo $count === 0 ? 1 : 2;
    }

    public static function checkOutStudent($alumno, $estado) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $fecha = H::getTime('Y-m-d');

        $checkout = $database->prepare("UPDATE academic_data
                                        SET baja = :estado,
                                            fecha_baja = :fecha
                                        WHERE student_id = :alumno;");
        $update = $checkout->execute(array(':estado' => $estado, ':fecha' => $fecha, ':alumno' => $alumno));

        echo $update ? 1 : 0;
    }

     ///////////////////////////////////////////////////////////////////////
    // = = = = = = = = = = = ALUMNOS DE BAJA = = = = = = = = = = = = = = //
   ///////////////////////////////////////////////////////////////////////

    public static function getStudentsCheckout(){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT s.*, ad.studies, ad.last_grade, g.class_id
                FROM students as s,
                     academic_data as ad,
                     groups as g
                WHERE s.student_id = ad.student_id
                  AND ad.baja      = 1
                  AND s.student_id = g.student_id";

        $query = $database->prepare($sql);
        $query->execute();

        if ($query->rowCount() > 0) {
            $students = $query->fetchAll();

            $alumos = array();
            foreach ($students as $row) {
                $id_tutor = 0;
                $tutor = '- - -';
                $curso = '<a class="link adding_group"
                             data-student="'.$row->student_id.'"
                             data-toggle="modal"
                             data-target="#add_to_group"
                             title="Agregar grupo"><strong>Agregar a Grupo</strong></a>';
                $clase = 0;

                if ($row->id_tutor !== '0') {
                    $getTutor = $database->prepare("SELECT id_tutor, namet, surname1, surname2
                                                    FROM tutors WHERE id_tutor = :tutor
                                                    LIMIT 1;");
                    $getTutor->execute(array(':tutor' => $row->id_tutor));
                    if ($getTutor->rowCount() > 0) {
                        $info = $getTutor->fetch();
                        $id_tutor = $info->id_tutor;
                        $tutor = ucwords(strtolower($info->namet)).' '.ucwords(strtolower($info->surname1));
                    }
                }

                if ($row->class_id !== NULL) {
                    $qry = $database->prepare("SELECT c.id as clase,
                                                      cu.id as course,
                                                      l.id as grupo,
                                                      cu.name,
                                                      l.level
                                               FROM classes as c, courses as cu, levels as l
                                               WHERE c.id = :clase
                                                 AND c.id_course = cu.id
                                                 AND c.id_level  = l.id
                                               LIMIT 1;");
                    $qry->execute(array(':clase' => $row->class_id));

                    if ($qry->rowCount() > 0) {
                        $fila = $qry->fetch();
                        $clase = $fila->clase;
                        $curso = '<a class="link change_group"
                                     data-student="'.$row->student_id.'"
                                     data-group="'.$fila->grupo.'"
                                     data-course="'.$fila->course.'"
                                     data-clase="'.$fila->clase.'"
                                     title="Cambiar grupo">'.$fila->name.' '.$fila->level.'</a>';

                    }
                }

                $alumnos[$row->student_id] = new stdClass();
                $alumnos[$row->student_id]->id = $row->student_id;
                $alumnos[$row->student_id]->name      = ucwords(strtolower($row->name));
                $alumnos[$row->student_id]->surname   = ucwords(strtolower($row->surname));
                $alumnos[$row->student_id]->lastname  = ucwords(strtolower($row->lastname));
                $alumnos[$row->student_id]->avatar    = $row->avatar;
                $alumnos[$row->student_id]->tutor_id  = $id_tutor;
                $alumnos[$row->student_id]->tutor     = $tutor;
                $alumnos[$row->student_id]->birthdays = $row->birthday;
                $alumnos[$row->student_id]->age   = $row->age;
                $alumnos[$row->student_id]->genre = $row->genre;
                $alumnos[$row->student_id]->clase = $clase;
                $alumnos[$row->student_id]->course= $curso;
                $alumnos[$row->student_id]->study = $row->studies;
                $alumnos[$row->student_id]->grade = $row->last_grade;
            }
            self::displayStudentsCheckout($alumnos);
        } else {
            echo '<h4 class="text-center text-primary subheader">No hay Alumnos de baja.</h4>';
        }
    }

    public static function displayStudentsCheckout($alumnos){
        if (count($alumnos) > 0) {
            echo '<div class="table-responsive">';
                echo '<table id="tbl_checkout"
                             class="table table-bordered table-hover">';
                    echo '<thead>';
                        echo '<tr class="info">';
                            echo '<th class="text-center">Foto</th>';
                            echo '<th class="text-center">Apellidos</th>';
                            echo '<th class="text-center">Nombre</th>';
                            echo '<th class="text-center">Edad</th>';
                            echo '<th class="text-center">Escolaridad</th>';
                            echo '<th class="text-center">Grupo</th>';
                            echo '<th class="text-center">Tutor</th>';
                            echo '<th class="text-center">Opciones</th>';
                        echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                        foreach ($alumnos as $row) {
                            $url = Config::get('URL').Config::get('PATH_AVATAR_STUDENT');
                            $avatar = '<img class="foto-mini" src="'.$url.$row->avatar.'.jpg" alt="avatar">';
                            echo '<tr class="row_data">';
                            echo '<td class="text-center">'.$avatar.'</td>';
                            echo '<td class="text-center txt">'.$row->surname.' '.$row->lastname.'</td>';
                            echo '<td class="text-center txt">'.$row->name.'</td>';
                            echo '<td class="text-center txt">'.$row->age.'</td>';
                            echo '<td class="text-center txt">'.$row->study.'</td>';
                            echo '<td class="text-center txt">'.$row->course.'</td>';
                            echo '<td class="text-center txt">'.$row->tutor.'</td>';
                            echo '<td class="text-center">
                                    <div class="btn-group">

                                      <a href="javascript:void(0)"
                                         data-target="#"
                                         class="btn btn-main btn-xs btn-raised dropdown-toggle"
                                         data-toggle="dropdown">Más.. &nbsp;&nbsp; <span class="caret"></span></a>
                                      <ul class="dropdown-menu student">
                                        <li>
                                            <a href="'.Config::get('URL').'alumno/perfilAlumno/'.$row->id.'"
                                               data-student="'.$row->id.'"
                                               data-tutor="'.$row->tutor_id.'"
                                               data-clase="'.$row->clase.'">
                                                <span class="o-blue glyphicon glyphicon-record"></span> Detalles</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"
                                               class="checkin_student"
                                               data-alumno="'.$row->id.'"
                                               data-nombre="'.$row->name.' '.$row->surname.'">
                                                    <span class="o-purple glyphicon glyphicon-record"></span>
                                                    Dar de Alta
                                            </a>
                                        </li>
                                      </ul>
                                    </div>
                                 </td>';
                            echo '</tr>';
                        }
                    echo '</tbody>';
                echo '</table>';
                echo "<br><br><br>";
            echo '</div>';
        } else {
            echo '<h4 class="text-center text-primary subheader">No hay Alumnos de baja.</h4>';
        }
    }
    ////////////////////////////////////////////////////////////////////
    //= = = = = = = C R E A T E   N E W   S T U D E N T = = = = = = = //
    ////////////////////////////////////////////////////////////////////

    public static function tutorExist($name, $surname, $lastname){
        $database = DatabaseFactory::getFactory()->getConnection();
        $name     = '%'.$name.'%';
        $surname  = '%'.$surname.'%';
        $lastname = '%'.$lastname.'%';

        $sql = "SELECT id_tutor, namet, surname1, surname2, job, cellphone, phone, relationship, phone_alt
                FROM tutors
                WHERE namet    LIKE :name
                  AND surname1 LIKE :surname
                  AND surname2 LIKE :lastname;";
        $query = $database->prepare($sql);
        $query->execute(array(':name' => $name, ':surname' => $surname, ':lastname' => $lastname));

        if ($query->rowCount() > 0) {
            return $query->fetch();
        }
    }

    public static function addNewTutor($surname, $lastname, $name, $relation, $job, $tel_celular, $tel_casa, $tel_alt, $relation_alt){
        $database = DatabaseFactory::getFactory()->getConnection();

        $name = ucwords(strtolower($name));
        $surname = ucwords(strtolower($surname));
        $lastname = ucwords(strtolower($lastname));

        $registro = H::getTime();
        $sql = "INSERT INTO tutors(namet, surname1, surname2,
                                   job, cellphone, phone,
                                   relationship, phone_alt, relationship_alt, created_at)
                            VALUES(:name, :surname, :lastname,
                                   :job, :cellphone, :phone,
                                   :relation, :phone_alt, :relation_alt, :created_at);";
        $query = $database->prepare($sql);
        $query->execute(array(
                ':name'         => $name,
                ':surname'      => $surname,
                ':lastname'     => $lastname,
                ':job'          => $job,
                ':cellphone'    => $tel_celular,
                ':phone'        => $tel_casa,
                ':relation'     => $relation,
                ':phone_alt'    => $tel_alt,
                ':relation_alt' => $relation_alt,
                ':created_at'   => $registro
            ));

        if ($query->rowCount() > 0) {
            Session::set('tutor', $database->lastInsertId());
            return $database->lastInsertId();
        } else {
            return 0;
        }
    }

    public static function addNewAddress($user, $street, $number, $between, $colony, $user_type){
        $database = DatabaseFactory::getFactory()->getConnection();

        $registro = H::getTime();
        $sql = "INSERT INTO address(user_id, user_type, street,
                                    st_number, st_between, colony,
                                    city, zipcode, state,
                                    country,created_at)
                            VALUES(:user, :user_type, :street,
                                   :st_number, :st_between, :colony,
                                   :city, :zipcode, :state, :country,
                                   :register);";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':user'       => $user,
            ':user_type'  => $user_type,
            ':street'     => $street,
            ':st_number'  => $number,
            ':st_between' => $between,
            ':colony'     => $colony,
            ':city'       => 'Felipe Carrillo Puerto',
            ':zipcode'    => 77200,
            ':state'      => 'Quintana Roo',
            ':country'    => 'México',
            ':register'   => $registro));

        if ($query->rowCount() > 0) {
            $addres_id = $database->lastInsertId();
            if ((int)$user_type === 1) {
                Session::set('addres_street', $street);
                Session::set('addres_number', $number);
                Session::set('addres_between', $between);
                Session::set('addres_colony', $colony);
                Session::set('address_id', $addres_id );

                Session::add('feedback_positive','Datos del tutor guardados exitosamente.');
            } else {
                self::updateAddress($user, $addres_id);
                Session::add('feedback_positive','Datos del alumno guardados exitosamente.');
            }
        } else {
            self::rollbackTutor($user);
            Session::add('feedback_negative','Los datos no se han guardado, intente de nuevo por favor.');
        }
    }

    public static function rollbackTutor($tutor){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = $database->prepare("DELETE FROM tutors WHERE id_tutor = :tutor;");
        $sql->execute(array(':tutor' => $tutor));

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function saveNewStudent($surname, $lastname, $name, $birthday, $genre, $civil_status, $cellphone, $reference, $sickness, $medication, $comment){

        $name = ucwords(strtolower($name));
        $surname = ucwords(strtolower($surname));
        $lastname = ucwords(strtolower($lastname));

        $database = DatabaseFactory::getFactory()->getConnection();

        $tutor = Session::get('tutor') ? Session::get('tutor') : 0;
        $edad = H::getAge($birthday);

        $sql = $database->prepare("INSERT INTO students(id_tutor,
                                                        name,
                                                        surname,
                                                        lastname,
                                                        birthday,
                                                        age,
                                                        genre,
                                                        edo_civil,
                                                        cellphone,
                                                        reference,
                                                        sickness,
                                                        medication,
                                                        comment_s)
                                                 VALUES(:tutor,
                                                        :name,
                                                        :surname,
                                                        :lastname,
                                                        :birthday,
                                                        :age,
                                                        :genre,
                                                        :edo_civil,
                                                        :cellphone,
                                                        :reference,
                                                        :sickness,
                                                        :medication,
                                                        :comment_s);");
        $sql->execute(array(':tutor'      => $tutor,
                            ':name'       => $name,
                            ':surname'    => $surname,
                            ':lastname'   => $lastname,
                            ':birthday'   => $birthday,
                            ':age'        => $edad,
                            ':genre'      => $genre,
                            ':edo_civil'  => $civil_status,
                            ':cellphone'  => $cellphone,
                            ':reference'  => $reference,
                            ':sickness'   => $sickness,
                            ':medication' => $medication,
                            ':comment_s'  => $comment));

        if ($sql->rowCount() > 0) {
            return $database->lastInsertId();
        } else {
            return false;
        }
    }

    public static function saveStudentDetails($student, $invoice, $homestay, $docto_id){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = $database->prepare("INSERT INTO students_details(id_student, facturacion,
                                                                homestay, acta_nacimiento)
                                                         VALUES(:student, :factura,
                                                                :homestay, :acta);");
        $sql->execute(array(':student'  => $student,
                            ':factura'  => $invoice,
                            ':homestay' => $homestay,
                            ':acta'     => $docto_id));
        if ($sql->rowCount() > 0) {
            Session::set('student_id', $student);
            return true;
        } else {
            return false;
        }
    }

    public static function updateAddress($student, $address){
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = $database->prepare("UPDATE students
                                   SET address_id = :address
                                   WHERE student_id = :student;");
        $save = $sql->execute(array(':student' => $student, ':address' => $address));

        if ($save) {
            Session::add('feedback_positive','Datos del alumno guardados exitosamente.');
        } else {
            Session::add('feedback_negative','Error al guardar el domicilio.');
        }
    }

    public static function rollbackStudent($student){
        $database = DatabaseFactory::getFactory()->getConnection();

        $delete = $database->prepare("DELETE FROM students WHERE student_id = :student;");
        $delete->execute(array(':student' => $student));
    }

    public static function saveAcademicData($clase_id, $ocupation, $workplace, $studies, $last_grade,$previus_course, $description_previo, $start_at){
        $database = DatabaseFactory::getFactory()->getConnection();

        $start_at = H::getTime('Y-m-d');
        if (Session::get('student_id')) {
            $student = Session::get('student_id');
        } else {
            $sql = $database->prepare("SELECT student_id FROM students ORDER BY student_id DESC LIMIT 1;");
            $sql->execute();
            if ($sql->rowCount() === 1) {
                $sql = $sql->fetch();
                $student = $sql->student_id;
            } else {
                $student = 1;
            }
        }

        $save = $database->prepare("INSERT INTO academic_data(student_id, id_clase,
                                                              ocupation, workplace,
                                                              studies, last_grade,
                                                              previus_course, description_previo,
                                                              start_at)
                                                       VALUES(:student, :clase, :ocupation,
                                                              :workplace, :studies, :grade,
                                                              :isprevius, :previus, :start_date);");
        $save->execute(array(':student'    => $student,
                             ':clase'      => $clase_id,
                             ':ocupation'  => $ocupation,
                             ':workplace'  => $workplace,
                             ':studies'    => $studies,
                             ':grade'      => $last_grade,
                             ':isprevius'  => $previus_course,
                             ':previus'    => $description_previo,
                             ':start_date' => $start_at));

        if ($save->rowCount() > 0) {
            $setGroup = $database->prepare("INSERT INTO groups(class_id, student_id, date_begin, state)
                                                        VALUES(:clase, :alumno, :fecha_inicio, 1);");
            $setGroup->execute(array(':clase' => $clase_id, ':alumno' => $student, ':fecha_inicio' => $start_at));
            Session::add('feedback_positive', 'Inscripción completa.');
            // Destroy all sessions variables about the inscription process
            if (Session::get('tutor'))          { Session::destroy('tutor'); }
            if (Session::get('addres_street'))  { Session::destroy('addres_street'); }
            if (Session::get('addres_number'))  { Session::destroy('addres_number'); }
            if (Session::get('addres_between')) { Session::destroy('addres_between'); }
            if (Session::get('addres_colony'))  { Session::destroy('addres_colony'); }
            if (Session::get('address_id'))     { Session::destroy('address_id'); }
            if (Session::get('student_id'))     { Session::destroy('student_id'); }

        } else {
            Session::add('feedback_negative', 'Error al guardar los datos academicos, intentelo de nuevo.');
        }
    }


    /////////////////////////////////////////////////////////
    // =  = = = = = = = = UPDATE STUDENTS DATA = = = = = = //
    /////////////////////////////////////////////////////////

    public static function updateStudentData($student_id, $tutor, $name, $surname, $lastname, $birthdate, $genre, $edo_civil, $cellphone, $reference, $street, $number, $between, $colony, $sickness, $medication, $homestay, $acta, $invoice, $comentario) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $name     = ucwords(strtolower($name));
        $surname  = ucwords(strtolower($surname));
        $lastname = ucwords(strtolower($lastname));
        $age      = H::getAge($birthdate);

        if ($tutor !== 0) {
            $user = $tutor;
            $typo = 1;
        } else {
            $user = $student_id;
            $typo = 2;
        }

        $sql = $database->prepare("UPDATE students SET name       = :name,
                                                       surname    = :surname,
                                                       lastname   = :lastname,
                                                       birthday   = :birthdate,
                                                       age        = :age,
                                                       genre      = :genre,
                                                       edo_civil  = :edo_civil,
                                                       cellphone  = :cellphone,
                                                       reference  = :reference,
                                                       sickness   = :sickness,
                                                       medication = :medication,
                                                       comment_s  = :comentario
                                    WHERE student_id = :student_id;");
        $update  =  $sql->execute(array(':name'      => $name,
                                        ':surname'   => $surname,
                                        ':lastname'  => $lastname,
                                        ':birthdate' => $birthdate,
                                        ':age'       => $age,
                                        ':genre'     => $genre,
                                        ':edo_civil' => $edo_civil,
                                        ':cellphone' => $cellphone,
                                        ':reference' => $reference,
                                        ':sickness'  => $sickness,
                                        ':medication' => $medication,
                                        ':comentario' => $comentario,
                                        ':student_id' => $student_id));

        if ($update) {
            $set_up  =  $database->prepare("UPDATE address
                                            SET street     = :calle,
                                                st_number  = :numero,
                                                st_between = :entre,
                                                reference  = :referencia,
                                                colony     = :colonia
                                            WHERE user_id  = :user
                                              AND user_type = :tipo;");
            $set_up->execute(array(':calle'  => $street,
                                   ':numero' => $number,
                                   ':entre'  => $between,
                                   ':referencia' => $reference,
                                   'colonia' => $colony,
                                   ':user'   => $user,
                                   ':tipo'   => $typo));

            $set_details =  $database->prepare("UPDATE students_details
                                                SET facturacion     = :factura,
                                                    homestay        = :homestay,
                                                    acta_nacimiento = :acta
                                                WHERE id_student = :student;");
            $set_details->execute(array(':factura'  => $invoice,
                                        ':homestay' => $homestay,
                                        ':acta'     => $acta,
                                        ':student'  => $student_id));
            Session::add('feedback_positive', "Datos del Alumno actualizados correctamente");
        } else {
            Session::add('feedback_negative', "Error al actualizar, intente de nuevo por favor!");
        }
    }

    public static function updateTutorData($tutor, $name, $surname, $lastname, $job, $relationship, $phone, $cellphone, $relation_alt, $phone_alt){
        $database = DatabaseFactory::getFactory()->getConnection();
        $name     = ucwords(strtolower($name));
        $surname  = ucwords(strtolower($surname));
        $lastname = ucwords(strtolower($lastname));

        $update  =  $database->prepare("UPDATE tutors
                                        SET namet     = :name,
                                            surnamet  = :surname,
                                            lastnamet = :lastname,
                                            job       = :job,
                                            phone     = :phone,
                                            cellphone = :cellphone,
                                            relationship = :relation,
                                            phone_alt      = :phone_alt,
                                            relationship_alt = :relation_alt
                                        WHERE id_tutor = :tutor");
        $update= $update->execute(array(':name'         => $name,
                                        ':surname'      => $surname,
                                        ':lastname'     => $lastname,
                                        ':job'          => $job,
                                        ':phone'        => $phorene,
                                        ':cellphone'    => $cellphone,
                                        ':relation'     => $relationship,
                                        ':phone_alt'    => $phone_alt,
                                        ':relation_alt' => $relation_alt,
                                        ':tutor'        => $tutor));
        if ($update) {
            Session::add('feedback_positive', 'Datos del Tutor actualizados correctamente.');
        } else {
            Session::add('feedback_negative', "Error al actualizar, intente de nuevo por favor!");
        }
    }

    public static function updateAcademicData($alumno, $ocupacion, $lugar_trabajo, $estudios, $grado){
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql =  $database->prepare("UPDATE students_details
                                    SET ocupation  = :ocupacion,
                                        workplace  = :lugar,
                                        studies    = :estudios,
                                        lastgrade  = :grado
                                    WHERE student_id = :alumno;");
        $update  =  $sql->execute(array(':ocupacion' => $ocupacion,
                                        ':lugar'     => $lugar_trabajo,
                                        ':estudios'  => $estudios,
                                        ':grado'     => $grado,
                                        ':alumno'    => $alumno));

        if ($update) {
            Session::add('feedback_positive', "Datos Academicos actualizados correctamente");
        } else {
            Session::add('feedback_negative', "Error al actualizar, intente de nuevo por favor!");
        }
    }
}
