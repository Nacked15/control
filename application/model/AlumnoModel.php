<?php

class AlumnoModel
{
    public static function getStudentByID($student){
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT a.name, a.surname, a.lastname, a.birthday,
                       a.age, a.genre, a.edo_civil, a.cellphone,
                       a.reference, a.sickness, a.medication, a.avatar,
                       a.comment_s, a.status, ad.ocupation,
                       ad.workplace, ad.studies, ad.last_grade,
                       ad.start_at, sd.convenio, sd.facturacion, sd.homestay, sd.acta_nacimiento
                FROM students as a, academic_data as ad, students_details as sd
                WHERE a.student_id = :student
                  AND a.student_id = ad.student_id
                  AND a.student_id = sd.id_student
                LIMIT 1;";
        $query = $database->prepare($sql);
        $query->execute(array(':student' => $student));

        if ($query->rowCount() > 0) {
            return $query->fetch();
        }
    }

    public static function getTutorByID($tutor){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT namet, surname1, surname2,
                       job, cellphone, phone, relationship,
                       phone_alt, relationship_alt 
                FROM tutors 
                WHERE id_tutor = :tutor LIMIT 1;";
        $query = $database->prepare($sql);
        $query->execute(array(':tutor' => $tutor));

        if ($query->rowCount() > 0) {
            return $query->fetch();
        }
    }

    public static function getClaseByID($clase){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT c.id as clase, cu.name as curso, l.level as grupo
                FROM classes as c, courses as cu, levels as l 
                WHERE c.id = :clase
                  AND c.id_course = cu.id
                  AND c.id_level  = l.id
                  AND c.status    = 1;";
        $query = $database->prepare($sql);
        $query->execute(array(':clase' => $clase));

        if ($query->rowCount() > 0) {
            return $query->fetch();
        }
    }

    public static function getAddressByUser($student, $tutor){
        $database = DatabaseFactory::getFactory()->getConnection();
        if ((int)$tutor !== 0) {
            $sql = $database->prepare("SELECT * FROM address 
                                       WHERE user_id = :user AND user_type = :typo;");
            $sql->execute(array(':user' => $tutor, ':typo' => 1));
        } else {
            $sql = $database->prepare("SELECT * FROM address 
                                       WHERE user_id = :user AND user_type = :typo;");
            $sql->execute(array(':user' => $student, ':typo' => 2));
        }

        if ($sql->rowCount() > 0) {
            return $sql->fetch();
        }
    }


    ////////////////////////////////////////////////////////////////////
    //= = = = = = = =  G E T T E R S  &  S E T T E R S  = = = = = = = //
    ////////////////////////////////////////////////////////////////////

    public static function getStudents($curso = 1){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT s.*, c.id as clase, ad.studies, ad.last_grade, 
                       cu.name as curso, l.level
                FROM students as s,
                     academic_data as ad,
                     groups as g, 
                     classes as c, 
                     courses as cu, 
                     levels as l
                WHERE s.student_id = ad.student_id
                  AND s.student_id = g.student_id
                  AND g.class_id   = c.id
                  AND c.status     = 1
                  AND c.id_course  = cu.id
                  AND c.id_level   = l.id
                  AND cu.id        = :curso";

        $query = $database->prepare($sql);
        $query->execute(array(':curso' => $curso));

        if ($query->rowCount() > 0) {
            $students = $query->fetchAll();

            $alumos = array();
            $id_tutor = 0;
            $tutor = '- - -';
            foreach ($students as $row) {
                if ((int)$row->id_tutor !== 0) {
                    $getTutor = $database->prepare("SELECT id_tutor, namet, surname1, surname2
                                                    FROM tutors WHERE id_tutor = :tutor
                                                    LIMIT 1;");
                    $getTutor->execute(array(':tutor' => $row->id_tutor));
                    if ($getTutor->rowCount() > 0) {
                        $info = $getTutor->fetch();
                        $id_tutor = $info->id_tutor;
                        $tutor = $info->namet.' '.$info->surname1;
                    }
                }
                
                $alumnos[$row->student_id] = new stdClass();
                $alumnos[$row->student_id]->id = $row->student_id;
                $alumnos[$row->student_id]->name = $row->name;
                $alumnos[$row->student_id]->surname = $row->surname;
                $alumnos[$row->student_id]->lastname = $row->lastname;
                $alumnos[$row->student_id]->avatar = $row->avatar;
                $alumnos[$row->student_id]->tutor_id = $id_tutor;
                $alumnos[$row->student_id]->tutor = $tutor;
                $alumnos[$row->student_id]->birthdays = $row->birthday;
                $alumnos[$row->student_id]->age = $row->age;
                $alumnos[$row->student_id]->genre = $row->genre;
                $alumnos[$row->student_id]->clase = $row->clase;
                $alumnos[$row->student_id]->course = $row->curso;
                $alumnos[$row->student_id]->group = $row->level;
                $alumnos[$row->student_id]->study = $row->studies;
                $alumnos[$row->student_id]->grade = $row->last_grade;
            }
            self::displayStudents($alumnos, $curso);
        } else {
            echo '<h4 class="text-center text-naatik">No hay Alumnos inscritos en este nivel.</h4>';
        }
    }

    public static function getStudentsAll(){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT s.*, ad.studies, ad.last_grade, g.class_id
                FROM students as s,
                     academic_data as ad,
                     groups as g
                WHERE s.student_id = ad.student_id
                  AND s.student_id = g.student_id";
        
        $query = $database->prepare($sql);
        $query->execute();

        if ($query->rowCount() > 0) {
            $students = $query->fetchAll();

            $alumos = array();
            $id_tutor = 0;
            $tutor = '- - -';
            $curso = 'Agregar';
            $grupo = 'Grupo';
            $clase = 0;
            foreach ($students as $row) {
                if ((int)$row->id_tutor !== 0) {
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

                if ($row->class_id != NULL) {
                    $qry = $database->prepare("SELECT c.id as clase, cu.name, l.level 
                                               FROM classes as c, courses as cu, levels as l
                                               WHERE c.id = :clase
                                                 AND c.id_course = cu.id
                                                 AND c.id_level  = l.id
                                               LIMIT 1;");
                    $qry->execute(array(':clase' => $row->class_id));

                    if ($qry->rowCount() > 0) {
                        $fila = $qry->fetch();
                        $clase = $fila->clase;
                        $grupo = $fila->level;
                        $curso = $fila->name;
                    }
                }
                
                $alumnos[$row->student_id] = new stdClass();
                $alumnos[$row->student_id]->id = $row->student_id;
                $alumnos[$row->student_id]->name = ucwords(strtolower($row->name));
                $alumnos[$row->student_id]->surname = ucwords(strtolower($row->surname));
                $alumnos[$row->student_id]->lastname = ucwords(strtolower($row->lastname));
                $alumnos[$row->student_id]->avatar = $row->avatar;
                $alumnos[$row->student_id]->tutor_id = $id_tutor;
                $alumnos[$row->student_id]->tutor = $tutor;
                $alumnos[$row->student_id]->birthdays = $row->birthday;
                $alumnos[$row->student_id]->age = $row->age;
                $alumnos[$row->student_id]->genre = $row->genre;
                $alumnos[$row->student_id]->clase = $clase;
                $alumnos[$row->student_id]->course= $curso;
                $alumnos[$row->student_id]->group = $grupo;
                $alumnos[$row->student_id]->study = $row->studies;
                $alumnos[$row->student_id]->grade = $row->last_grade;
            }
            self::displayStudents($alumnos, 5);
        } else {
            echo '<h4 class="text-center text-naatik">No hay Alumnos inscritos.</h4>';
        }
    }

    public static function displayStudents($alumnos, $curso){
        if (count($alumnos) > 0) {
            echo '<div class="table-responsive">';
                echo '<table id="tbl_students_'.$curso.'" 
                             class="table table-bordered table-hover table-striped">';
                    echo '<thead>';
                        echo '<tr class="info">';
                            echo '<th class="text-center">Foto</th>';
                            echo '<th class="text-center">Apellidos</th>';
                            echo '<th class="text-center">Nombre</th>';
                            echo '<th class="text-center">Edad</th>';
                            echo '<th class="text-center">Grado Escolar</th>';
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
                            echo '<td class="text-center txt">'.$row->course.' '.$row->group.'</td>';
                            echo '<td class="text-center txt">'.$row->tutor.'</td>';
                            echo '<td class="text-center">
                                    <button data-student="'.$row->id.'"
                                            data-tutor="'.$row->tutor_id.'"
                                            data-clase="'.$row->clase.'"
                                            data-curso="'.$curso.'"
                                            type="button" 
                                            class="btn btn-xs btn-more profile">Más..</button>
                                 </td>';
                            echo '</tr>';
                        } 
                    echo '</tbody>';
                echo '</table>';
            echo '</div>';
        } else {
            echo '<h4 class="text-center text-naatik">No hay Alumnos inscritos en este nivel.</h4>';
        }
    }

    public static function getLevelsByClass($id) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT c.id, c.id_level, l.level 
                FROM classes as c, levels as l
                WHERE c.id_course = :id
                  AND c.id_level  = l.id;";
        $query = $database->prepare($sql);
        $query->execute(array(':id' => $id));

        if($query->rowCount() > 0){
            return $query->fetchAll();
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
        $database = DatabaseFactory::getFactory()->getConnection();

        $tutor = Session::get('tutor') ? Session::get('tutor') : 0;
        $created_at = H::getTime();
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
                                                        comment_s, 
                                                        status, 
                                                        created_at) 
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
                                                        :comment_s, 
                                                        :status, 
                                                        :created_at );");
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
                            ':comment_s'  => $comment,
                            ':status'     => 1,
                            ':created_at' => $created_at));

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

}
