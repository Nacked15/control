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

		$datos = array();
		if ($query->rowCount() > 0) {
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
			$addr = explode(',', $tutor->address_t);
			$datos['street']  = $addr[0];
			$datos['number']  = $addr[1];
			$datos['between'] = $addr[2];
			$datos['colony']  = $addr[3];
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
		$data = array();
		if ($query->rowCount() > 0) {
			$info = $query->fetch();
			$data['ocupatio']     = $info->ocupation;
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

		return false;
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



	public static function importStudentToNewDB($student) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare("SELECT * FROM naatikdb.student WHERE id_student = :student;");
		$query->execute(array(':student' => $student));
		$student = array();
		if ($query->rowCount() > 0) {
			$alumno = $query->fetch();
			$students[$alumno->id_student] = new stdClass();
			$students[$alumno->id_student]->count        = $count++;
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
			$students[$alumno->id_student]->tutor        = self::getTutor($alumno->id_tutor);
			$students[$alumno->id_student]->ubication    = self::getUbicationAddress($alumno->id_tutor);
			$students[$alumno->id_student]->academic_data = self::getAcademicInfo($alumno->id_student);
			$students[$alumno->id_student]->details       = self::getExtraInfo($alumno->id_student);
			$students[$alumno->id_student]->pay_data      = self::getPayHistoric($alumno->id_student);
			$students[$alumno->id_student]->scholar_data  = self::getBecasHistoric($alumno->id_student);
		}
		return $student;
	}

	public static function importPays() {
		$database = DatabaseFactory::getFactory()->getConnection();

	}

}
