<?php

class GeneralModel
{
	public static function students($curso) {
        $database = DatabaseFactory::getFactory()->getConnection();

        if ($curso !== '6') {
            $alumnos = "SELECT s.student_id, s.id_tutor, s.name, s.surname,
                               s.lastname, s.age, s.genre, s.avatar, g.class_id,
                               g.convenio, sd.studies, sd.lastgrade
                        FROM students as s, students_groups as g, students_details as sd, classes as c
                        WHERE s.status = 1
                          AND deleted  = 0
                          AND s.student_id = g.student_id
                          AND g.class_id   = c.class_id
                          AND s.student_id = sd.student_id";
        } else {
            $alumnos = "SELECT s.student_id, s.id_tutor, s.name, s.surname,
                               s.lastname, s.age, s.genre, s.avatar, g.class_id,
                               g.convenio, sd.studies, sd.lastgrade
                        FROM students as s, students_groups as g, students_details as sd
                        WHERE s.status = 1
                          AND deleted  = 0
                          AND s.student_id = g.student_id
                          AND s.student_id = sd.student_id";
            
        }

        switch ($curso) {
            case '1': //-> English club y big tots
                $alumnos .= ' AND (c.course_id = 1 OR c.course_id = 2) ORDER BY s.surname ASC';
                break;
            case '2': //->primary
                $alumnos .= ' AND c.course_id = 3 ORDER BY s.surname ASC';
                break;
            case '3': //->primary
                $alumnos .= ' AND c.course_id = 4 ORDER BY s.surname ASC';
                break;
            case '4': //->adultos y avanzado
                $alumnos .= ' AND (c.course_id = 5 OR c.course_id = 6) ORDER BY s.surname ASC';
                break;
            default:
                $alumnos .= ' ORDER BY s.surname ASC';
                break;
        }
        $alumnos = $database->prepare($alumnos);
        $alumnos->execute();

        if ($alumnos->rowCount() > 0) {
            $alumnos = $alumnos->fetchAll();
            $datos = null;
            $count = 1;
            foreach ($alumnos as $alumno) {
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
                $datos[$count]->id       = $alumno->student_id;
                $datos[$count]->nombre   = $alumno->name .' '. $alumno->surname;
                $datos[$count]->avatar   = $alumno->avatar;
                $datos[$count]->id_tutor = $id_tutor;
                $datos[$count]->tutor    = $nombre_tutor;
                $count++;
            }
            
            return $datos;
        }

        return null;
    }

    

    public static function createBackupDatabase(){

        $db_host = Config::get('DB_HOST'); //Host del Servidor MySQL
        $db_name = Config::get('DB_NAME'); //Nombre de la Base de datos
        $db_user = Config::get('DB_USER'); //Usuario de MySQL
        $db_pass = Config::get('DB_PASS'); //Password de Usuario MySQL
        $bk_path = Config::get('PATH_BACKUPS'); //Carpeta destino del Backup

        $backup_file = $bk_path . $db_name . '_' .date("Ymd-His") . ".sql";
        $command = "mysqldump --opt -h $db_host  -u $db_user -p$db_pass $db_name > $backup_file";
         
        system($command,$output);
        echo $db_host.'<br>';
        echo $db_name.'<br>';
        echo $db_user.'<br>';
        echo $db_pass.'<br>';
        echo $output;
    }




    // public static function listStudents($curso, $pagina=1, $limite=10) {
    //     $database = DatabaseFactory::getFactory()->getConnection();
    //     $counter =  $database->prepare("SELECT student_id
    //                                     FROM students
    //                                     WHERE status  = 1
    //                                       AND deleted = 0;");
    //     $counter->execute();

    //     if ($counter->rowCount() > 0) {
    //         $inicio = 0;
    //         if($pagina && is_numeric($pagina)){
    //             $inicio = ($pagina - 1) * $limite;
    //         }

    //         if ($curso !== '6') {
    //             $alumnos = "SELECT s.student_id, s.id_tutor, s.name, s.surname,
    //                                s.lastname, s.age, s.genre, s.avatar, g.class_id,
    //                                g.convenio, sd.studies, sd.lastgrade
    //                         FROM students as s, students_groups as g, students_details as sd, classes as c
    //                         WHERE s.status = 1
    //                           AND deleted  = 0
    //                           AND s.student_id = g.student_id
    //                           AND g.class_id   = c.class_id
    //                           AND s.student_id = sd.student_id";
    //         } else {
    //             $alumnos = "SELECT s.student_id, s.id_tutor, s.name, s.surname,
    //                                s.lastname, s.age, s.genre, s.avatar, g.class_id,
    //                                g.convenio, sd.studies, sd.lastgrade
    //                         FROM students as s, students_groups as g, students_details as sd
    //                         WHERE s.status = 1
    //                           AND deleted  = 0
    //                           AND s.student_id = g.student_id
    //                           AND s.student_id = sd.student_id";
                
    //         }

    //         switch ($curso) {
    //             case '1': //-> English club y big tots
    //                 $alumnos .= ' AND (c.course_id = 1 OR c.course_id = 2) ORDER BY s.surname ASC LIMIT :inicio, :limite';
    //                 break;
    //             case '2': //->primary
    //                 $alumnos .= ' AND c.course_id = 3 ORDER BY s.surname ASC LIMIT :inicio, :limite';
    //                 break;
    //             case '3': //->primary
    //                 $alumnos .= ' AND c.course_id = 4 ORDER BY s.surname ASC LIMIT :inicio, :limite';
    //                 break;
    //             case '4': //->adultos y avanzado
    //                 $alumnos .= ' AND (c.course_id = 5 OR c.course_id = 6) ORDER BY s.surname ASC LIMIT :inicio, :limite';
    //                 break;
    //             default:
    //                 $alumnos .= ' ORDER BY s.surname ASC LIMIT :inicio, :limite';
    //                 break;
    //         }
            
    //     }
    //     $alumnos = $database->prepare($alumnos);
    //     $alumnos->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    //     $alumnos->bindParam(':limite', $limite, PDO::PARAM_INT);
    //     $alumnos->execute();

    //     if ($alumnos->rowCount() > 0) {
    //         $alumnos = $alumnos->fetchAll();
    //         $datos = array();
    //         $count = 1;
    //         foreach ($alumnos as $alumno) {
    //             //-> Tutor del Alumno
    //             $id_tutor     = 0;
    //             $nombre_tutor = '- - - -';
    //             if ($alumno->id_tutor !== NULL) {
    //                 $tutor = $database->prepare("SELECT id_tutor, namet, surnamet, lastnamet
    //                                                 FROM tutors
    //                                                 WHERE id_tutor = :tutor
    //                                              LIMIT 1;");
    //                 $tutor->execute(array(':tutor' => $alumno->id_tutor));
    //                 if ($tutor->rowCount() > 0) {
    //                     $tutor = $tutor->fetch();
    //                     $id_tutor = $tutor->id_tutor;
    //                     $nombre_tutor = $tutor->namet.' '.$tutor->surnamet;
    //                 }
    //             }

    //             $datos[$count] = new stdClass();
    //             $datos[$count]->id       = $alumno->student_id;
    //             $datos[$count]->nombre   = $alumno->name .' '. $alumno->surname;
    //             $datos[$count]->avatar   = $alumno->avatar;
    //             $datos[$count]->id_tutor = $id_tutor;
    //             $datos[$count]->tutor    = $nombre_tutor;
    //             $count++;
    //         }

    //         return $datos;
    //     }

    //     return null;
    // }

}
