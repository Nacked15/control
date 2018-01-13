<?php

class ImportOldDataModel
{
	public static function importStudents() {
		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare("SELECT * FROM naatikdb.student ORDER BY surname1_s;");
		$query->execute();
		$students = array();
		if ($query->rowCount() > 0) {
			$alumnos = $query->fetchAll();
			$count = 1;
			foreach ($alumnos as $alumno) {
				$students[$alumno->id_student] = new stdClass();
				$students[$alumno->id_student]->count        = $count++;
				$students[$alumno->id_student]->xported      = $alumno->exportado;
				$students[$alumno->id_student]->student_id   = $alumno->id_student;
				$students[$alumno->id_student]->name         = ucwords(strtolower($alumno->name_s));
				$students[$alumno->id_student]->surname      = ucwords(strtolower($alumno->surname1_s));
				$students[$alumno->id_student]->lastname     = ucwords(strtolower($alumno->surname2_s));
				$students[$alumno->id_student]->birthdate    = $alumno->birthday;
				$students[$alumno->id_student]->age          = $alumno->age;
				$students[$alumno->id_student]->genre        = $alumno->sexo;
				$students[$alumno->id_student]->civil_status = $alumno->edo_civil;
				$students[$alumno->id_student]->cellphone    = $alumno->cellphone;
				$students[$alumno->id_student]->reference    = $alumno->reference;
				$students[$alumno->id_student]->isckness     = $alumno->sickness;
				$students[$alumno->id_student]->medication   = $alumno->medication;
				$students[$alumno->id_student]->avatar       = $alumno->photo_s;
				$students[$alumno->id_student]->description  = $alumno->comment_s;
				$students[$alumno->id_student]->homestay     = $alumno->homestay;
				$students[$alumno->id_student]->status       = $alumno->status;
				$students[$alumno->id_student]->curso        = self::getCourse($alumno->id_student);
				$students[$alumno->id_student]->tutor        = self::getTutor($alumno->id_tutor);
				$students[$alumno->id_student]->ubication    = self::getUbicationAddress($alumno->id_tutor);
				$students[$alumno->id_student]->academic_data = self::getAcademicInfo($alumno->id_student);
				$students[$alumno->id_student]->details       = self::getExtraInfo($alumno->id_student);
				$students[$alumno->id_student]->pay_data      = self::getPayHistoric($alumno->id_student);
				$students[$alumno->id_student]->scholar_data  = self::getBecasHistoric($alumno->id_student);
			}

			return $students;
		}
	}

	public static function getTutor($tutor){
		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare("SELECT * FROM naatikdb.tutor 
									 WHERE id_tutor = :tutor
									   AND name_t != 'N/A'
									   AND surname1_t != 'N/A'
									   AND surname2_t != 'N/A'
									   AND phone != 'S/N' 
									 LIMIT 1;");
		$query->execute(array(':tutor' => $tutor));

		$datos = NULL;
		if ($query->rowCount() > 0) {
			$datos = array();
			$addres = array();
			$tutor = $query->fetch();
			$datos['id']           = $tutor->id_tutor;
			$datos['name']         = ucwords(strtolower($tutor->name_t));
			$datos['surname']      = ucwords(strtolower($tutor->surname1_t));
			$datos['lastname']     = ucwords(strtolower($tutor->surname2_t));
			$datos['job']          = $tutor->job;
			$datos['phone']        = $tutor->phone;
			$datos['cellphone']    = $tutor->cellphone_t;
			$datos['phone_alt']    = $tutor->phone_alt;
			$datos['relationship'] = $tutor->relationship;
			$datos['relationship_alt'] = $tutor->relationship_alt;
			$mapa = self::getUbicationAddress($tutor->id_tutor);
			$addr = explode(',', $tutor->address_t);
			$address['street']  = $addr[0];
			$address['number']  = $addr[1];
			$address['between'] = $addr[2];
			$address['colony']  = $addr[3];
			$address['latitud']   = $mapa->latitud;
			$address['longitud']  = $mapa->longitud;
			$datos['direccion'] = $address;
		}

		return $datos;
	}

	public static function getCourse($student){
		$database = DatabaseFactory::getFactory()->getConnection();

		$query = $database->prepare("SELECT nc.course, ng.group
									 FROM naatikdb.academic_info as ai, 
									      naatikdb.classes as c, 
									      naatikdb.naatik_course as nc, 
									      naatikdb.groups_nc as ng
									 WHERE ai.id_student = :student
									   AND ai.id_classes = c.id_class
									   AND c.id_course   = nc.id_course
									   AND c.id_group    = ng.id_group
									 LIMIT 1");
		$query->execute(array(':student' => $student));
		if ($query->rowCount() > 0) {
			$data = $query->fetch();
			$curso = $data->course .' '. $data->group;
			return $curso;
		}

		return false;
	}

	public static function getUbicationAddress($user){
		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare("SELECT c.lat as latitud, c.long as longitud
									 FROM naatikdb.croquis as c
									 WHERE c.idtutor = :tutor LIMIT 1;");
		$query->execute(array(':tutor' => $user));

		if ($query->rowCount() > 0) {
			return $query->fetch();
		}

		return false;
	}

	public static function getAcademicInfo($student) {
		$database = DatabaseFactory::getFactory()->getConnection();

		$query = $database->prepare("SELECT *
									 FROM naatikdb.academic_info
									 WHERE id_student = :student
									 LIMIT 1");
		$query->execute(array(':student' => $student));
		$data = NULL;
		if ($query->rowCount() > 0) {
			$data = array();
			$info = $query->fetch();
			$data['ocupation']    = $info->ocupation;
			$data['workplace']    = $info->workplace;
			$data['studies']      = $info->studies;
			$data['level']        = $info->level;
			$data['prior_course'] = $info->prev_course;
			$data['sep']          = self::getSEPInfo($info->reg_sep);
			$data['date_init']    = $info->date_init_s;
			$date_baja   = $info->date_bajaSt === '0000-00-00' ? NULL : $info->date_bajaSt;
			$data['date_baja']    = $date_baja;
			$date_egreso = $info->date_egreso === '0000-00-00' ? NULL : $info->date_egreso;
			$data['date_egreso']  = $date_egreso;
		}

		return $data;
	}

	public static function getSEPInfo($id_sep){
		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare("SELECT * FROM naatikdb.sep 
									 WHERE id_sep = :sep AND issep = 'si' LIMIT 1;");
		$query->execute(array(':sep' => $id_sep));

		if ($query->rowCount() > 0) {
			return $query->fetch();
		}
		return false;
	}

	public static function getExtraInfo($student) {
		$database = DatabaseFactory::getFactory()->getConnection();

		$query = $database->prepare("SELECT reg_nacimiento as acta, convenio, facturacion
									 FROM naatikdb.info_extrast
									 WHERE id_st = :student
									 LIMIT 1");
		$query->execute(array(':student' => $student));
		if ($query->rowCount() > 0) {
			return $query->fetch();
		}

		return false;
	}

	public static function getPayHistoric($student){
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = $database->prepare("SELECT * FROM naatikdb.pays WHERE id_student = :student;");
		$sql->execute(array(':student' => $student));

		$data = array();
		if ($sql->rowCount() > 0) {
			$pagos = $sql->fetchAll();
			foreach ($pagos as $pago) {
				$data['ene'] = $pago->jan;
				$data['feb'] = $pago->feb;
				$data['mar'] = $pago->mar;
				$data['abr'] = $pago->apr;
				$data['may'] = $pago->may;
				$data['jun'] = $pago->jun;
				$data['jul'] = $pago->jul;
				$data['ago'] = $pago->aug;
				$data['sep'] = $pago->sep;
				$data['oct'] = $pago->oct;
				$data['nov'] = $pago->nov;
				$data['dic'] = $pago->dece;
				$data['anio'] = $pago->year_pay;
				$data['ciclo']  = $pago->ciclo;
				$data['becado']   = $pago->becado;
				$data['comentario'] = $pago->comment;
			}
		}

		return $data;
	}

	public static function getBecasHistoric($student){
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = $database->prepare("SELECT request, togrant, date_scholar 
								   FROM naatikdb.scholar
								   WHERE id_student = :student;");
		$sql->execute(array(':student' => $student));

		if ($sql->rowCount() > 0) {
			return $sql->fetchAll();
		}
		 return false;
	}



	public static function importStudent($student) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare("SELECT * FROM naatikdb.student WHERE id_student = :student;");
		$query->execute(array(':student' => $student));
		$student = array();
		if ($query->rowCount() > 0) {
			$alumno = $query->fetch();
			$address = array();
			// $student['name']         = ucwords(strtolower($alumno->name_s));
			// $student['surname']      = ucwords(strtolower($alumno->surname1_s));
			// $student['lastname']     = ucwords(strtolower($alumno->surname2_s));
			// $student['birthdate']    = $alumno->birthday;
			// $student['age']          = $alumno->age;
			// $student['genre']        = $alumno->sexo;
			// $student['civil_stat']   = $alumno->edo_civil;
			// $student['cellphone']    = $alumno->cellphone;
			// $student['reference']    = $alumno->reference;
			// $student['sickness']     = $alumno->sickness;
			// $student['medication']   = $alumno->medication;
			// $student['avatar']       = strtolower($alumno->sexo);
			// $student['comment']      = $alumno->comment_s;
			// $student['homestay']     = $alumno->homestay;
			// $student['status']       = $alumno->status;
			// $addr = explode(',', $alumno->address_s);
			// $address['street']  = $addr[0];
			// $address['number']  = $addr[1];
			// $address['between'] = $addr[2];
			// $address['colony']  = $addr[3];
			// $student['direccion']    = $address;
			// $student['tutor']        = self::getTutor($alumno->id_tutor);
			// $student['mapa']         = self::getUbicationAddress($alumno->id_tutor);
			$student['academic']     = self::getAcademicInfo($alumno->id_student);
			$student['detail']       = self::getExtraInfo($alumno->id_student);
			$student['pay_data']     = self::getPayHistoric($alumno->id_student);
			$student['scholar_data'] = self::getBecasHistoric($alumno->id_student);
		}
		return $student;
	}

	public static function saveStudent($alumno){
		$database = DatabaseFactory::getFactory()->getConnection();

		if ($alumno['tutor'] === null) {
			$tutor_id = 0;
		} else {
			$save = self::saveTutor($alumno['tutor']);
			$tutor_id = !$save ? 0 : $save;
		}

		$edad = H::getAge($alumno['birthdate']);
        $sql =  $database->prepare("INSERT INTO students(id_tutor, name, surname, lastname,
                                                         birthday, age, genre, edo_civil,
                                                         cellphone, reference, sickness,
                                                         medication, avatar, comment_s, status)
                                                 VALUES(:tutor, :name, :surname, :lastname,
                                                        :birthday, :age, :genre, :edo_civil,
                                                        :cellphone, :reference, :sickness,
                                                        :medication, :avatar, :comment_s, :status);");
        $sql->execute(array(':tutor'      => $tutor_id,
                            ':name'       => $alumno['name'],
                            ':surname'    => $alumno['surname'],
                            ':lastname'   => $alumno['lastname'],
                            ':birthday'   => $alumno['birthdate'],
                            ':age'        => $edad,
                            ':genre'      => $alumno['genre'],
                            ':edo_civil'  => $alumno['civil_stat'],
                            ':cellphone'  => $alumno['cellphone'],
                            ':reference'  => $alumno['reference'],
                            ':sickness'   => $alumno['sickness'],
                            ':medication' => $alumno['medication'],
                            ':avatar'     => $alumno['avatar'],
                            ':comment_s'  => $alumno['comment'],
	                        ':status'     => $alumno['status']));

        if ($sql->rowCount() > 0) {
            $student_id = $database->lastInsertId();

            //Si no tiene tutor, guardar la dirección del alumno.
            if ($alumno['tutor'] === null) {
                $sql = "INSERT INTO address(user_id, user_type, street, st_number, st_between, colony,
                                            city, zipcode, state, country, latitud, longitud)
                                    VALUES(:user, :user_type, :street, :st_number, :st_between, :colony,
                                           :city, :zipcode, :state, :country, :latitud, :longitud);";
                $query = $database->prepare($sql);
                $query->execute(array(
				                    ':user'       => $student_id,
				                    ':user_type'  => 2,
				                    ':street'     => $alumno['direccion']['street'],
				                    ':st_number'  => $alumno['direccion']['number'],
				                    ':st_between' => $alumno['direccion']['between'],
				                    ':colony'     => $alumno['direccion']['colony'],
				                    ':city'       => 'Felipe Carrillo Puerto',
				                    ':zipcode'    => 77200,
				                    ':state'      => 'Quintana Roo',
				                    ':country'    => 'México',
				                    ':latitud'    => $alumno['mapa']['latitud'],
				                    ':longitud'   => $alumno['mapa']['longitud'])
				            	);

                if ($query->rowCount() < 1) {
                    $commit = false;
                }
            }

            //Agregar detalles del alumno
            $details =  $database->prepare("INSERT INTO students_details(student_id, facturacion, homestay,
                                                                         acta_nacimiento, ocupation,
                                                                         workplace, studies, lastgrade,
                                                                         prior_course, prior_comments) 
                                                                VALUES(:student, :invoice, :homestay,
                                                                       :acta, :ocupation, :workplace, 
                                                                       :studies, :lastgrade, 1, 
                                                                       :prior_comments)");
            $details->execute(array(':student'        => $student_id,
                                    ':invoice'        => $alumno['detail']['facturacion'],
                                    ':homestay'       => $alumno['homestay'],
                                    ':acta'           => $alumno['detail']['acta'],
                                    ':ocupation'      => $alumno['academic']['ocupation'],
                                    ':workplace'      => $alumno['academic']['workplace'],
                                    ':studies'        => $alumno['academic']['studies'],
                                    ':lastgrade'      => $alumno['academic']['level'],
                                    ':prior_comments' => $alumno['academic']['prior_course']));

            if ($details->rowCount() > 0) {
                //Crear lista de pagos mensual.
                $pay_list = $database->prepare("INSERT INTO students_pays(student_id)
                                                                    VALUES(:student);");
                $pay_list->execute(array(':student' => $student_id));

                //Agregar al grupo especificado
                $group = $database->prepare("INSERT INTO students_groups(class_id, student_id, date_begin) 
                                                                VALUES(:clase, :student, :begin_date)");
                $group->execute(array(':clase' => $clase,
                                      ':student' => $student_id,
                                      ':begin_date' => $date_init_student));
                if ($group->rowCount() < 1) {
                    $commit = false;
                } else {
                    //Guaradar la foto del alumno.
                    Session::destroy('tutor');
                    Session::destroy('alumno');
                    Session::destroy('address');
                }
            } else {;
                $commit = false;
            }
        } else {
            $commit = false;
        }
	}


	public static function saveTutor($tutor){
        $database = DatabaseFactory::getFactory()->getConnection();

        $save_tutor  = "INSERT INTO tutors(namet, surnamet, lastnamet, job, cellphone, phone,
                                           relationship, phone_alt, relationship_alt)
                                    VALUES(:name, :surname, :lastname, :job, :cellphone, :phone,
                                           :relation, :phone_alt, :relation_alt);";
        $query = $database->prepare($save_tutor);
        $query->execute(array(
                            ':name'         => ucwords(strtolower($tutor['name'])),
                            ':surname'      => ucwords(strtolower($tutor['surname'])),
                            ':lastname'     => ucwords(strtolower($tutor['lastname'])),
                            ':job'          => $tutor['ocupation'],
                            ':cellphone'    => $tutor['cellphone'],
                            ':phone'        => $tutor['phone'],
                            ':relation'     => $tutor['relationship'],
                            ':phone_alt'    => $tutor['phone_alt'],
                            ':relation_alt' => $tutor['relation_alt']
                        ));

        if ($query->rowCount() > 0) {
        	$get_id = $database->prepare("SELECT id_tutor FROM tutors ORDER BY id_tutor DESC LIMIT 1;");
        	$get_id->execute();
        	$tutor_id = $get_id->fetch()->id_tutor;
        	self::saveAddress($tutor_id, $tutor['direccion'], 1);
        	return $tutor_id; 
        }
        return false;  
    }

    public static function saveAddress($user, $address, $user_type){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO address(user_id, user_type, street, st_number, st_between, colony,
                                    city, zipcode, state, country, latitud, longitud)
                            VALUES(:user, :user_type, :street, :st_number, :st_between, :colony,
                                   :city, :zipcode, :state, :country, :latitud, :longitud);";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':user'       => $user,
            ':user_type'  => $user_type,
            ':street'     => $address['street'],
            ':st_number'  => $address['number'],
            ':st_between' => $address['between'],
            ':colony'     => $address['colony'],
            ':city'       => 'Felipe Carrillo Puerto',
            ':zipcode'    => 77200,
            ':state'      => 'Quintana Roo',
            ':country'    => 'México',
            ':latitud'    => $address['latitud'],
            ':longitud'   => $address['longitud']));

        if ($query->rowCount() < 1) {
            $commit = false;
        }            
    }

}
