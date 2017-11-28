<?php

class GeneralModel
{
	public static function students($curso) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $alumnos = "SELECT s.student_id, s.id_tutor, s.name, s.surname,
                           s.lastname, s.avatar, g.class_id
                    FROM students as s, students_groups as g, students_details as sd
                    WHERE s.status = 1
                      AND deleted  = 0
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

        return false;
    }


}
