<?php

class CursoModel
{

    public static function getCourses() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT course_id, course 
                FROM courses";
        $query = $database->prepare($sql);
        $query->execute();    

        return $query->fetchAll();
    }

    public static function getGroups() {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT group_id, group_name FROM groups";
        $query = $database->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function addNewClass($curso, $grupo, $f_inicio, $f_fin, $ciclo, $dias, 
                                       $h_inicio, $h_salida, $c_normal, $c_promocional, 
                                       $c_inscripcion, $maestro){
        $database = DatabaseFactory::getFactory()->getConnection();
        $commit = true;
        $dias  = (array)$dias;
        $h_inicio = date('H:i', strtotime($h_inicio));
        $h_salida = date('H:i', strtotime($h_salida));

        $database->beginTransaction();
        try{
            //Horario de la clase.
            $sql = "INSERT INTO schedules(year, date_init, date_end, hour_init, hour_end) 
                                    VALUES(:ciclo, :f_inicio, :f_fin, :h_inicio, :h_salida);";
            $query = $database->prepare($sql);
            $query->execute(array(':ciclo'      => $ciclo, 
                                  ':f_inicio'   => $f_inicio,
                                  ':f_fin'      => $f_fin,
                                  ':h_inicio'   => $h_inicio,
                                  ':h_salida'   => $h_salida));

            if($query->rowCount() === 1){
                $horario = $database->lastInsertId();
                //Indicar los dias
                $error = 0;
                foreach ($dias as $dia) {
                    $day = $database->prepare("INSERT INTO schedul_days(schedul_id, day_id)
                                                                 VALUES(:horario, :dia)");
                    $day->execute(array(':horario' => $horario, ':dia' => $dia));

                    if($day->rowCount() === 0){
                        $error++;
                    }
                }

                if($error === 0) {
                    $f_registro = H::getTime();
                    $clase = "INSERT INTO classes(course_id, 
                                                  group_id, 
                                                  schedul_id, 
                                                  teacher_id,
                                                  costo_normal,
                                                  costo_promocional,
                                                  costo_inscripcion,
                                                  status, 
                                                  created_at)
                                            VALUES(:curso,
                                                   :grupo,
                                                   :horario,
                                                   :maestro,
                                                   :c_normal,
                                                   :c_promocional,
                                                   :c_inscripcion,
                                                   1,
                                                   :f_registro);";
                    $insert = $database->prepare($clase);
                    $insert->execute(array(':curso'           => $curso,
                                           ':grupo'           => $grupo,
                                           ':horario'         => $horario,
                                           ':maestro'         => $maestro,
                                           ':c_normal'        => $c_normal,
                                           ':c_promocional'   => $c_promocional,
                                           ':c_inscripcion'   => $c_inscripcion,
                                           ':f_registro'      => $f_registro));
                    if($insert->rowCount() === 0){
                        $commit = false;
                        Session::add('feedback_negative','Error al crear la clase.');
                    }
                } else {
                    $commit = false;
                    Session::add('feedback_negative','Error al insertar los dias.');
                }

            }else { // if boda
                $commit = false;
                Session::add('feedback_negative','Error al crear la clase, intente de nuevo por favor.');
            }

        }catch (PDOException $e) {
            Session::add('feedback_negative','Error al crear la clase, intente de nuevo por favor.');
            $commit = false;
        }

        if (!$commit) {
            $database->rollBack();
            return false;
        }else {
            $database->commit();
            Session::add('feedback_positive','La nueva clase se ha creado correctamente');
            return true;
        }

    }

    public static function getClases($page) {
        H::getLibrary('paginadorLib');
        $paginator = new \Paginador();
        $usr_type  = (int)Session::get('user_type');
        $filas     = 15;
        $page      = (int)$page;

        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT c.class_id, c.teacher_id, c.schedul_id, cu.course_id, cu.course,
                       g.group_id, g.group_name, h.year, h.date_init, h.date_end, h.hour_init, h.hour_end
                FROM classes as c, courses as cu, 
                     groups as g, schedules as h
                WHERE c.course_id  = cu.course_id
                  AND c.group_id   = g.group_id
                  AND c.schedul_id = h.schedul_id
                  AND c.status     = 1";

        if ($usr_type === 3) {
            $user = Session::get('user_id');
            $sql .= " AND c.teacher_id = :user ORDER BY cu.course_id ASC;";
            $query = $database->prepare($sql);
            $query->execute(array(':user' => $user));
        } else {
            $sql .= " ORDER BY cu.course_id ASC;";
            $query = $database->prepare($sql);
            $query->execute();
        }
        
        if ($query->rowCount() > 0) {
            $clases = $query->fetchAll();
            $items  = $paginator->paginar($clases, $page, $filas);
            $classe = [];
            foreach ($items as $clase) {

                $id_maestro = 0;
                $maestro = '<a href="#" class="add-teacher" data-id="'.$clase->class_id.'" title="Add teacher">Agregar</a>';
                if ((int)$clase->teacher_id !== 0) {
                    $get = $database->prepare("SELECT user_id, name, lastname FROM users 
                                               WHERE user_type = 3 AND user_id = :user LIMIT 1;");
                    $get->execute(array(':user' => $clase->teacher_id));

                    if ($get->rowCount() > 0) {
                        $set = $get->fetch();
                        $id_maestro = $set->user_id;
                        $name = $set->name.' '.explode(' ', $set->lastname)[0];
                        $maestro = '<a href="#" 
                                       class="change-teacher" 
                                       data-id="'.$clase->class_id.'"
                                       data-teacher="'.$id_maestro.'"
                                       title="Change teacher">'.ucwords(strtolower($name)).'</a>';
                    }
                }

                $hora_inicio = date('g:i a', strtotime($clase->hour_init));
                $hora_salida = date('g:i a', strtotime($clase->hour_end));

                $classe[$clase->class_id] = new stdClass();
                $classe[$clase->class_id]->id         = $clase->class_id;
                $classe[$clase->class_id]->name       = $clase->course.' '.$clase->group_name;
                $classe[$clase->class_id]->inicia     = H::formatShortDate($clase->date_init);
                $classe[$clase->class_id]->termina    = H::formatShortDate($clase->date_end);
                $classe[$clase->class_id]->horario    = $hora_inicio.' - '.$hora_salida;
                $classe[$clase->class_id]->maestro_id = $id_maestro;
                $classe[$clase->class_id]->maestro    = $maestro;
                $classe[$clase->class_id]->horario_id = $clase->schedul_id;


            }
            $counter = $page > 0 ? (($page*$filas)-$filas) + 1 : 1;
            self::displayClases($classe, $counter);
            $paginacion = $paginator->getView('pagination_ajax', 'clases');
            echo '<div class="row" style="padding-top:0;">';
                echo '<div class="col-sm-12 text-center">';
                    echo $paginacion;
                echo '</div>';
            echo '</div>';
        } else {
            echo '<h4 class="text-center text-naatik">No hay clases registradas. Haga click en agregar nueva clase para crear clases.</h4>';
        }
    }

    public static function displayClases($classes, $counter){
        $user_type = (int)Session::get('user_account_type');
        $database = DatabaseFactory::getFactory()->getConnection();

        if (count($classes) > 0) {
            echo '<div class="table-responsive">';
            echo '<table class="table table-hover table-striped table-condensed">';
            echo '<thead>';
                echo '<tr class="info">';
                echo '<th>ID</th>';
                echo '<th>Clase</th>';
                echo '<th>Inicio</th>';
                echo '<th>Termino</th>';
                echo '<th>Dias</th>';
                echo '<th>Horario</th>';
                echo '<th>Maestro</th>';
                echo $user_type == 1 || $user_type == 2 ? '<th class="text-center">Opciones</th>' : '';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
                foreach ($classes as $clase) {
                    $days = $database->prepare("SELECT hd.schedul_id, hd.day_id, d.day 
                                                FROM schedul_days as hd, days as d
                                                WHERE hd.day_id     = d.day_id
                                                  AND hd.schedul_id = :horario;");
                    $days->execute(array(':horario' => $clase->horario_id));

                    echo '<tr>';
                    echo '<td>'.$counter++.'</td>';
                    echo '<td>'.$clase->name.'</td>';
                    echo '<td>'.$clase->inicia.'</td>';
                    echo '<td>'.$clase->termina.'</td>';
                    echo '<td>';
                        foreach ($days as $dia) {
                            echo $dia->day.'<br>';
                        }
                    echo '</td>';
                    echo '<td>'.$clase->horario.'</td>';
                    echo '<td>'.$clase->maestro.'</td>';
                    if ($user_type == 1 || $user_type == 2) {
                    echo '<td class="text-center">
                            <button type="button"
                                    id="'.$clase->id.'"
                                    data-horario="'.$clase->horario_id.'"
                                    class="btn btn-xs btn-info btn-raised updateClase">
                                        Edit
                            </button>
                            <button type="button"
                                    id="'.$clase->id.'"
                                    data-name="'.$clase->name.'" 
                                    class="btn btn-xs btn-danger btn-raised removeClase">
                                        Eliminar
                            </button>
                        </td>';
                    }
                    echo '</tr>';
                }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';             
        } else {
            echo '<h5 class="text-info text-center">No existen clases registradas.</h5>';
        }              
    }

    public static function getClass($clase) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT cu.course, g.group_name, c.schedul_id,
                       h.year, h.date_init, h.date_end, 
                       h.hour_init, h.hour_end, c.class_id, 
                       c.course_id, c.group_id, c.teacher_id, c.costo_inscripcion
                FROM classes as c, 
                     courses as cu, 
                     groups as g, 
                     schedules as h
                WHERE c.course_id  = cu.course_id
                  AND c.group_id   = g.group_id
                  AND c.schedul_id = h.schedul_id 
                  AND c.class_id   = :clase
                LIMIT 1;";
        $query = $database->prepare($sql);
        $query->execute(array(':clase' => $clase));

        if($query->rowCount() > 0){
            return $query->fetch();
        }
    }

    public static function getDays() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("SELECT * FROM days;");
        $query->execute();

        return $query->fetchAll();
    }

    public static function getDaysByClass($horario) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = $database->prepare("SELECT hd.day_id, d.day
                                   FROM schedul_days as hd, days as d
                                   WHERE hd.day_id     = d.day_id
                                     AND hd.schedul_id = :horario;");
        $sql->execute(array(':horario' => $horario));

        if ($sql->rowCount() > 0) {
            return $sql->fetchAll();      
        }
    }

    public static function setTeacher($class, $teacher){
        $database = DatabaseFactory::getFactory()->getConnection();

        if ((int)$teacher === 0) {
            $teacher = NULL;
        }

        $add = $database->prepare("UPDATE classes SET teacher_id = :teacher WHERE class_id = :class;");
        $save = $add->execute(array(':teacher' => $teacher, ':class' => $class));
        return $save;
    }


    public static function updateClass($clase, $curso, $grupo, $horario, $f_inicio, $f_fin, $ciclo, $dias, $h_inicio, $h_salida, $c_inscripcion, $maestro){

        $database = DatabaseFactory::getFactory()->getConnection();
        $commit = true;
        $dias  = (array)$dias;
        $h_inicio = date('H:i', strtotime($h_inicio));
        $h_salida = date('H:i', strtotime($h_salida));


        $database->beginTransaction();
        try{
            //Horario de la clase.
            $sql = $database->prepare("UPDATE schedules
                                       SET year = :ciclo, 
                                           date_init = :f_inicio,
                                           date_end  = :f_fin,
                                           hour_init = :h_inicio,
                                           hour_end  = :h_salida
                                       WHERE schedul_id = :horario;");
            $save = $sql->execute(array(':ciclo'    => $ciclo, 
                                        ':f_inicio' => $f_inicio,
                                        ':f_fin'    => $f_fin,
                                        ':h_inicio' => $h_inicio,
                                        ':h_salida' => $h_salida,
                                        ':horario'  => $horario));

            if($save){
                //Indicar los dias
                $error = 0;
                if (!self::getCurrentDayCourse($clase, $dias)) {
                    $error = 1;
                }
                foreach ($dias as $dia) {
                    $check = $database->prepare("SELECT day_id
                                                 FROM schedul_days 
                                                 WHERE schedul_id = :horario 
                                                   AND day_id     = :day;");
                    $check->execute(array(':horario' => $horario, ':day' => $dia));

                    if($check->rowCount() === 0){
                        $day = $database->prepare("INSERT INTO schedul_days(schedul_id, day_id)
                                                                     VALUES(:horario, :dia)");
                        $day->execute(array(':horario' => $horario, ':dia' => $dia));

                        if($day->rowCount() === 0){
                            $error++;
                        }
                    }
                }

                if($error === 0) {
                    $f_update = H::getTime();
                    $update = "UPDATE classes 
                              SET course_id  = :curso,
                                  group_id   = :nivel,
                                  teacher_id = :maestro,
                                  costo_inscripcion = :costo,
                                  updated_at = :f_update  
                              WHERE class_id = :clase;";

                    $insert = $database->prepare($update);
                    $set = $insert->execute(array( ':curso'    => $curso,
                                                   ':nivel'    => $grupo,
                                                   ':maestro'  => $maestro,
                                                   ':costo'    => $c_inscripcion,
                                                   ':f_update' => $f_update,
                                                   ':clase'    => $clase));
                    if(!$set){
                        $commit = false;
                        Session::add('feedback_negative','Error al actualizar la clase.');
                    }
                } else {
                    $commit = false;
                    Session::add('feedback_negative','Error al insertar los dias.');
                }

            }else { // if boda
                $commit = false;
                Session::add('feedback_negative','No se pudo actualizar los datos de la clase.');
            }

        }catch (PDOException $e) {
            Session::add('feedback_negative','Error al actualizar la clase, intente de nuevo por favor.');
            $commit = false;
        }

        if (!$commit) {
            $database->rollBack();
            return false;
        }else {
            $database->commit();
            Session::add('feedback_positive','Datos actualizados correctamente');
            return true;
        }

    }

    public static function getNumberStudentsByClass($clase) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $count = $database->prepare("SELECT class_id FROM students_groups WHERE class_id = :clase;");
        $count->execute(array(':clase' => $clase));

        if ($count->rowCount() > 0) {
            return $count->rowCount();
        }

        return 0;
    }

    public static function deleteClass($clase){
        $database = DatabaseFactory::getFactory()->getConnection(); 
        $delete = $database->prepare("DELETE FROM classes WHERE class_id = :clase");
        $delete->execute(array(':clase' => $clase));

        if ($delete->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public static function getCurrentDayCourse($clase, $dias) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = $database->prepare("SELECT sd.schedul_id, sd.day_id 
                                   FROM classes as c, schedul_days as sd
                                   WHERE c.class_id = :clase
                                     AND c.schedul_id = sd.schedul_id;");
        $sql->execute(array(':clase' => $clase));

        if ($sql->rowCount() > 0) {
            $days = $sql->fetchAll();
            $i=0;
            foreach ($days as $day) {
                if (in_array($day->day_id, $dias)) {
                    continue;
                } else {
                    $delete = $database->prepare("DELETE FROM schedul_days
                                                        WHERE schedul_id = :schedul
                                                          AND day_id     = :day;");

                    $delete->execute(array(':schedul' => $day->schedul_id, ':day' => $day->day_id));

                    if ($delete->rowCount === 0) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    public static function getCursos() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT course_id, course
                FROM courses";
        $query = $database->prepare($sql);
        $query->execute();    

        if ($query->rowCount() > 0) {
            self::displayCursos($query->fetchAll());
        } else {
            echo '<h4 class="text-center text-info">No hay Cursos</h4>';
        }
    }

    public static function displayCursos($courses){
        $cursos = (array)$courses;

        if (count($cursos)) {
            echo '<div class="table-responsive">';
            echo '<table id="tbl_cursos" class="table table-hover table-striped">';
            echo '<thead>';
                echo '<tr class="info">';
                echo '<th class="text-center">ID</th>';
                echo '<th class="text-center">Curso</th>';
                echo '<th class="text-center">Opciones</th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
                foreach ($cursos as $curso) {
                    echo '<tr>';
                    echo '<td class="text-center">'.$curso->course_id.'</td>'; 
                    echo '<td class="text-center">'.$curso->course.'</td>'; 
                    echo '<td class="text-center">
                            <button type="button"
                                    data-id="'.$curso->course_id.'"
                                    data-course="'.$curso->course.'" 
                                    class="btn btn-xs btn-info btn-raised btn_edit_course"
                                    data-toggle="modal" 
                                    data-target="#editCourse" >Editar</button>
                          </td>'; 
                    echo '</tr>';   
                }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';                 
        } else {
            echo '<h5 class="text-info text-center">No existen Cursos registradas.</h5>';
        }
    }

    public static function newCourse($curso){
        $database = DatabaseFactory::getFactory()->getConnection();
        $insert = $database->prepare("INSERT INTO courses(course) VALUES(:curso);");
        $insert->execute(array(':curso' => $curso));

        echo $insert->rowCount() > 0 ? 1 : 0;
    }

    public static function updateCourse($id, $curso){
        $database = DatabaseFactory::getFactory()->getConnection();
        $query = $database->prepare("UPDATE courses SET course = :curso WHERE course_id = :id;");
        $update = $query->execute(array(':curso' => $curso, ':id' => $id));

        if ($update) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public static function getGrupos() {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT group_id, group_name FROM groups";
        $query = $database->prepare($sql);
        $query->execute();

        if ($query->rowCount() > 0) {
            self::displayGrupos($query->fetchAll());
        } else {
            echo '<h4 class="text-center text-info">No hay Grupos</h4>';
        }
    }

    public static function displayGrupos($groups){
        $grupos = (array)$groups;

        if (count($grupos) > 0) {
            echo '<div class="table-responsive">';
            echo '<table id="tbl_niveles" class="table table-hover table-striped">';
            echo '<thead>';
                echo '<tr class="info">';
                echo '<th class="text-center">ID</th>';
                echo '<th class="text-center">Grupo</th>';
                echo '<th class="text-center">Opciones</th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
                foreach ($grupos as $nivel) {
                    echo '<tr>';
                    echo '<td class="text-center">'.$nivel->group_id.'</td>'; 
                    echo '<td class="text-center">'.$nivel->group_name.'</td>'; 
                    echo '<td class="text-center">
                            <button type="button"
                                    data-id="'.$nivel->group_id.'"
                                    data-group="'.$nivel->group_name.'" 
                                    class="btn btn-xs btn-info btn-raised btn_edit_group"
                                    data-toggle="tooltip" 
                                    title="Edit">Editar</button>
                            <button type="button" 
                                    data-id="'.$nivel->group_id.'"
                                    data-group="'.$nivel->group_name.'"
                                    class="btn btn-xs btn-danger btn-raised btn_remove_group"
                                    data-toggle="tooltip" 
                                    title="Delete">Borrar</button>
                          </td>'; 
                    echo '</tr>';   
                }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';                  
        } else {
           echo '<h5 class="text-info text-center">No existen Grupos registradas.</h5>'; 
        }
    }

    public static function newGroup($grupo){
        $database = DatabaseFactory::getFactory()->getConnection();
        $insert = $database->prepare("INSERT INTO groups(group_name) VALUES(:grupo);");
        $insert->execute(array(':grupo' => $grupo));

        echo $insert->rowCount() > 0 ? 1 : 0;
    }

    public static function updateGroup($id, $grupo){
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("UPDATE groups SET group_name = :grupo WHERE group_id = :id;");
        $update = $query->execute(array(':grupo' => $grupo, ':id' => $id));

        if ($update) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public static function deleteGroup($grupo){
        $database = DatabaseFactory::getFactory()->getConnection();

        $delete = $database->prepare("DELETE FROM groups WHERE group_id = :grupo;");
        $delete->execute(array(':grupo' => $grupo));

        if ($delete->rowCount() > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }


}
